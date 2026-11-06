<?php
// FILE: app/Http/Controllers/User/ReviewController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Simpan review baru — hanya jika transaksi success
     */
    public function store(Request $request, Mountain $mountain)
    {
        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'rating.required'  => 'Pilih rating bintang terlebih dahulu.',
            'comment.required' => 'Tulis komentar Anda.',
            'comment.min'      => 'Komentar minimal 10 karakter.',
            'comment.max'      => 'Komentar maksimal 1000 karakter.',
        ]);

        // Cek transaksi sukses
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('mountain_id', $mountain->id)
            ->where('status', 'success')
            ->first();

        abort_if(!$transaction, 403, 'Hanya peserta dengan pembayaran sukses yang dapat memberi ulasan.');

        // Cek apakah sudah pernah review
        if (Review::where('user_id', Auth::id())->where('mountain_id', $mountain->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk trip ini.');
        }

        Review::create([
            'user_id'        => Auth::id(),
            'mountain_id'    => $mountain->id,
            'transaction_id' => $transaction->id,
            'rating'         => $validated['rating'],
            'comment'        => $validated['comment'],
        ]);

        return back()->with('success', '⭐ Ulasan Anda berhasil dikirim! Terima kasih telah berbagi pengalaman.');
    }

    /**
     * Update review milik sendiri
     */
    public function update(Request $request, Review $review)
    {
        abort_if($review->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $review->update($validated);

        return back()->with('success', 'Ulasan berhasil diperbarui!');
    }

    /**
     * Hapus review milik sendiri
     */
    public function destroy(Review $review)
    {
        abort_if($review->user_id !== Auth::id(), 403);
        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}