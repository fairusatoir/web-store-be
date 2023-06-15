<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Services\ProductService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $productService;
    protected $transactionService;

    public function __construct(ProductService $productService, TransactionService $transactionService)
    {
        $this->productService = $productService;
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $income = $this->transactionService->sumIncome($request);
        $sales = $this->transactionService->countTransaction($request);
        $item = $this->transactionService->getAll(5);
        $pie = [
            'pending' => $this->transactionService->getCountByStatus($request, "PENDING"),
            'failed' => $this->transactionService->getCountByStatus($request, "FAILED"),
            'success' => $this->transactionService->getCountByStatus($request, "SUCCESS"),
        ];
        return view('pages.dashboard')->with([
            'income' => $income,
            'sales' => $sales,
            'data' => $item,
            'pie' => $pie,
        ]);
    }
}
