<?php

namespace App\Http\Controllers\Backend;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalTransactions = Transaction::count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $successTransactions = Transaction::where('status', 'success')->count();
        $failedTransactions = Transaction::where('status', 'failed')->count();

        // Gunakan paginasi untuk 5 transaksi terbaru
        $recentTransactions = Transaction::orderBy('created_at', 'desc')->paginate(5);

        return view('backend.dashboard.index',
        compact('totalTransactions', 'pendingTransactions', 'successTransactions', 'failedTransactions', 'recentTransactions'
        ));
    }

}
