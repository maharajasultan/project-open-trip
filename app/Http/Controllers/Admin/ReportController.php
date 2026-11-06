<?php
// FILE: app/Http/Controllers/Admin/ReportController.php
// Jalankan: php artisan make:controller Admin/ReportController

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Halaman laporan bulanan — filter bulan & tahun
     */
    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year',  now()->year);

        // ── Ringkasan bulan yang dipilih ──────────────────────
        $summary = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('
                COUNT(*) as total_transactions,
                SUM(CASE WHEN status = "success" THEN 1 ELSE 0 END) as total_success,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as total_pending,
                SUM(CASE WHEN status IN ("failed","expired") THEN 1 ELSE 0 END) as total_failed,
                SUM(CASE WHEN status = "success" THEN total_price ELSE 0 END) as total_revenue,
                SUM(CASE WHEN status = "success" THEN participant_count ELSE 0 END) as total_participants
            ')
            ->first();

        // ── Transaksi per gunung (bulan ini) ─────────────────
        $perMountain = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'success')
            ->select('mountain_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(participant_count) as total_participants'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->with('mountain:id,name,location')
            ->groupBy('mountain_id')
            ->orderByDesc('total_revenue')
            ->get();

        // ── Data harian (untuk chart) ─────────────────────────
        $dailyData = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'success')
            ->select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        // Lengkapi semua hari dalam bulan
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $chartLabels  = [];
        $chartRevenue = [];
        $chartOrders  = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $chartLabels[]  = $d;
            $chartRevenue[] = $dailyData->get($d)?->revenue ?? 0;
            $chartOrders[]  = $dailyData->get($d)?->orders  ?? 0;
        }

        // ── Transaksi detail bulan ini (untuk tabel cetak) ───
        $transactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with(['mountain:id,name', 'user:id,name'])
            ->orderBy('created_at')
            ->get();

        // ── Perbandingan bulan sebelumnya ─────────────────────
        $prevMonth = $month === 1 ? 12 : $month - 1;
        $prevYear  = $month === 1 ? $year - 1 : $year;

        $prevRevenue = Transaction::whereMonth('created_at', $prevMonth)
            ->whereYear('created_at', $prevYear)
            ->where('status', 'success')
            ->sum('total_price');

        $revenueGrowth = $prevRevenue > 0
            ? round((($summary->total_revenue - $prevRevenue) / $prevRevenue) * 100, 1)
            : ($summary->total_revenue > 0 ? 100 : 0);

        // ── Tahun tersedia untuk dropdown ─────────────────────
        $availableYears = Transaction::selectRaw('YEAR(created_at) as y')
            ->distinct()
            ->orderByDesc('y')
            ->pluck('y')
            ->toArray();

        if (!in_array(now()->year, $availableYears)) {
            array_unshift($availableYears, now()->year);
        }

        return view('admin.reports.index', compact(
            'summary', 'perMountain', 'transactions',
            'chartLabels', 'chartRevenue', 'chartOrders',
            'month', 'year', 'prevRevenue', 'revenueGrowth', 'availableYears'
        ));
    }

    /**
     * Cetak / Export PDF laporan bulan ini
     * Tampilkan view print-friendly (window.print() di browser)
     */
    public function print(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year',  now()->year);

        $summary = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('
                COUNT(*) as total_transactions,
                SUM(CASE WHEN status = "success" THEN 1 ELSE 0 END) as total_success,
                SUM(CASE WHEN status IN ("failed","expired") THEN 1 ELSE 0 END) as total_failed,
                SUM(CASE WHEN status = "success" THEN total_price ELSE 0 END) as total_revenue,
                SUM(CASE WHEN status = "success" THEN participant_count ELSE 0 END) as total_participants
            ')
            ->first();

        $perMountain = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'success')
            ->select('mountain_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(participant_count) as total_participants'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->with('mountain:id,name,location')
            ->groupBy('mountain_id')
            ->orderByDesc('total_revenue')
            ->get();

        $transactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with(['mountain:id,name', 'user:id,name'])
            ->orderBy('created_at')
            ->get();

        $months = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];

        return view('admin.reports.print', compact(
            'summary', 'perMountain', 'transactions', 'month', 'year', 'months'
        ));
    }
}