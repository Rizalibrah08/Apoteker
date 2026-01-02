<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'items']);

        // Filter by Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
        } else {
            // Default: Month to Date
            // $query->whereMonth('created_at', now()->month)
            //       ->whereYear('created_at', now()->year);
        }

        // Filter by user role
        if ($request->user()->role == 'staff') {
            // Staff can only see their own transactions
            $query->where('user_id', $request->user()->id);
        } elseif ($request->filled('user_id')) {
            // Admin can filter by any user
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->latest()->get();

        // Calculate Stats
        $totalTransaksi = $transactions->count();
        $totalPendapatan = $transactions->sum('total_bayar');
        $averageTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Fetch Users for Filter
        $users = \App\Models\User::all();

        return view('backend.laporan.index', compact(
            'transactions',
            'totalTransaksi',
            'totalPendapatan',
            'averageTransaksi',
            'users'
        ));
    }
}
