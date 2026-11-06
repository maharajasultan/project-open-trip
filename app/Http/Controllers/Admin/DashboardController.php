<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_transactions'  => Transaction::count(),
            'total_participants'  => Transaction::sum('participant_count'),
            'total_revenue'       => Transaction::where('status', 'success')->sum('total_price'),
            'total_mountains'     => Mountain::count(),
            'total_users'         => User::where('role', 'user')->count(),
            'pending_count'       => Transaction::where('status', 'pending')->count(),
        ];

        $recent_transactions = Transaction::with(['user', 'mountain'])
            ->latest()
            ->take(10)
            ->get();

        $popular_mountains = Mountain::withCount('transactions')
            ->orderByDesc('transactions_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_transactions', 'popular_mountains'));
    }
}