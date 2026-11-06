<?php
// FILE: app/Http/Controllers/User/TransactionController.php
// VERSI TERBARU — Stok hanya berkurang jika bayar sukses, timer 10 menit

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Notification;

class TransactionController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey    = config('midtrans.server_key');
        MidtransConfig::$clientKey    = config('midtrans.client_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized  = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds        = config('midtrans.is_3ds');
    }

    /* ────────────────────────────────────────────────────────
     | STEP 1 — Tampilkan form data diri
     ─────────────────────────────────────────────────────── */
    public function showCheckoutForm(Mountain $mountain)
    {
        abort_if(!$mountain->is_active, 404);

        // Kuota dihitung dari stok yang tersedia (belum dikurangi pending)
        // Stok HANYA berkurang jika success, jadi available_quota sudah benar
        abort_if($mountain->available_quota <= 0, 403, 'Kuota sudah penuh!');

        return view('user.checkout.form', compact('mountain'));
    }

    /* ────────────────────────────────────────────────────────
     | STEP 2 — Simpan data diri → generate Snap Token
     |          PENTING: registered_count TIDAK dinaikkan di sini.
     |          Akan dinaikkan hanya saat webhook status=success.
     ─────────────────────────────────────────────────────── */
    public function processCheckout(Request $request, Mountain $mountain)
    {
        $validated = $request->validate([
            'full_name'         => 'required|string|max:255',
            'age'               => 'required|integer|min:10|max:99',
            'address'           => 'required|string|min:10',
            'no_wa'             => 'required|string|min:10|max:15',
            'email'             => 'required|email',
            'participant_count' => 'required|integer|min:1|max:' . $mountain->available_quota,
        ]);

        $totalPrice = $mountain->price * $validated['participant_count'];
        $orderId    = 'TRIP-' . strtoupper(Str::random(8)) . '-' . time();

        // Simpan transaksi — stok BELUM berkurang
        $transaction = Transaction::create([
            'order_id'          => $orderId,
            'user_id'           => Auth::id(),
            'mountain_id'       => $mountain->id,
            'full_name'         => $validated['full_name'],
            'age'               => $validated['age'],
            'address'           => $validated['address'],
            'no_wa'             => $validated['no_wa'],
            'email'             => $validated['email'],
            'participant_count' => $validated['participant_count'],
            'price_per_person'  => $mountain->price,
            'total_price'       => $totalPrice,
            'status'            => 'pending',
            // Expired 10 menit dari sekarang
            'expired_at'        => now()->addMinutes(10),
        ]);

        // Generate Midtrans Snap Token
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $validated['full_name'],
                'email'      => $validated['email'],
                'phone'      => $validated['no_wa'],
            ],
            'item_details' => [[
                'id'       => 'mountain-' . $mountain->id,
                'price'    => (int) $mountain->price,
                'quantity' => $validated['participant_count'],
                'name'     => 'Open Trip ' . $mountain->name,
            ]],
            // Midtrans expiry 10 menit
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit'       => 'minutes',
                'duration'   => 10,
            ],
            'callbacks' => [
                'finish' => route('payment.show', $transaction->id),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            $transaction->delete(); // rollback
            return back()->with('error', 'Gagal menghubungi payment gateway: ' . $e->getMessage());
        }

        return redirect()->route('payment.show', $transaction->id);
    }

    /* ────────────────────────────────────────────────────────
     | STEP 3 — Halaman pembayaran dengan countdown 10 menit
     ─────────────────────────────────────────────────────── */
    public function payment(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        // Jika sudah expired sebelum dibuka
        if ($transaction->expired_at && now()->gt($transaction->expired_at)
            && $transaction->status === 'pending') {
            $transaction->update(['status' => 'expired']);
            return redirect()->route('history')
                ->with('error', 'Waktu pembayaran telah habis. Silakan buat pesanan baru.');
        }

        $transaction->load('mountain');

        return view('user.checkout.payment', [
            'transaction' => $transaction,
            'client_key'  => config('midtrans.client_key'),
            // Sisa detik untuk countdown
            'seconds_left' => max(0, now()->diffInSeconds($transaction->expired_at, false)),
        ]);
    }

    /* ────────────────────────────────────────────────────────
     | WEBHOOK — Midtrans mengirim notifikasi status
     |   • success  → kurangi stok (registered_count++)
     |   • expired/failed/cancel → tidak ubah stok
     ─────────────────────────────────────────────────────── */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $paymentType       = $notification->payment_type;

            $transaction = Transaction::where('order_id', $orderId)->firstOrFail();

            // Jangan proses ulang jika sudah sukses
            if ($transaction->status === 'success') {
                return response()->json(['message' => 'Already processed']);
            }

            // Tentukan status akhir
            if ($transactionStatus === 'capture') {
                $status = ($fraudStatus === 'accept') ? 'success' : 'failed';
            } elseif ($transactionStatus === 'settlement') {
                $status = 'success';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'failure'])) {
                $status = 'failed';
            } elseif ($transactionStatus === 'expire') {
                $status = 'expired';
            } else {
                $status = 'pending';
            }

            $updateData = [
                'status'       => $status,
                'payment_type' => $paymentType,
            ];

            // ★ Stok HANYA berkurang saat SUKSES ★
            if ($status === 'success') {
                $updateData['paid_at'] = now();
                // Increment registered_count sesuai jumlah peserta
                $transaction->mountain->increment('registered_count', $transaction->participant_count);
            }

            $transaction->update($updateData);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'OK']);
    }

    /* ────────────────────────────────────────────────────────
     | Riwayat transaksi user
     ─────────────────────────────────────────────────────── */
    public function history()
    {
        $transactions = Transaction::with(['mountain', 'review'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.history', compact('transactions'));
    }
}