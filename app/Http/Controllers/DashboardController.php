<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Default (Admin) Stats
        // 1. Stats (Revenue & Transactions - This Month)
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $transactionQuery = \App\Models\Transaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear);

        // Filter for Staff
        if ($user->role == 'staff') {
            $transactionQuery->where('user_id', $user->id);
        }

        $totalRevenue = $transactionQuery->sum('total_bayar');
        $totalTransactions = $transactionQuery->count();

        $stats = [
            'revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'transactions' => number_format($totalTransactions, 0, ',', '.'),
            'revenue_label' => $user->role == 'admin' ? 'Total Pendapatan' : 'Pendapatan Anda',
            'transactions_label' => $user->role == 'admin' ? 'Total Transaksi' : 'Transaksi Anda',
        ];

        // 2. Top Selling Products (Admin Only)
        $topProducts = [];
        if ($user->role == 'admin') {
            $topProducts = \App\Models\TransactionItem::select('obat_id', \Illuminate\Support\Facades\DB::raw('SUM(qty) as total_qty'))
                ->whereHas('transaction', function ($q) use ($currentMonth, $currentYear) {
                    $q->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                })
                ->with('obat')
                ->groupBy('obat_id')
                ->orderByDesc('total_qty')
                ->limit(5)
                ->get();
        }

        // 3. Expiring Soon (5 Months Threshold) & Already Expired
        $expiringSoon = [];
        $alreadyExpired = [];

        if ($user->role == 'admin') {
            $thresholdDate = now()->addMonths(5);

            // Upcoming Expiry
            $expiringSoon = \App\Models\Obat::where('expired_date', '<=', $thresholdDate)
                ->where('expired_date', '>=', now())
                ->orderBy('expired_date', 'asc')
                ->limit(5)
                ->get();

            // Already Expired
            $alreadyExpired = \App\Models\Obat::where('expired_date', '<', now())
                ->orderBy('expired_date', 'desc') // Most recently expired first
                ->limit(5)
                ->get();
        }

        // 4. Recent Transactions (Staff Only)
        $recentTransactions = [];
        if ($user->role == 'staff') {
            $recentTransactions = \App\Models\Transaction::where('user_id', $user->id)
                ->latest()
                ->limit(5)
                ->get();
        }

        return view('backend.dashboard.index', compact('stats', 'topProducts', 'expiringSoon', 'alreadyExpired', 'recentTransactions'));
    }
}
