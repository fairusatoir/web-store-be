<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $income = Transaction::with('details.product')
            ->where('transaction_status', 'SUCCESS')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->details->sum(function ($detail) use ($transaction) {
                    return $detail->product->price * $transaction->transaction_total;
                });
            });
        $sales = Transaction::count();
        $item = Transaction::orderBy('id', 'DESC')->take(5)->get();
        $pie = [
            'pending' => Transaction::where('transaction_status', 'PENDING')->count(),
            'failed' => Transaction::where('transaction_status', 'FAILED')->count(),
            'success' => Transaction::where('transaction_status', 'SUCCESS')->count(),
        ];
        return view('pages.dashboard')->with([
            'income' => $income,
            'sales' => $sales,
            'data' => $item,
            'pie' => $pie,
        ]);
    }
}
