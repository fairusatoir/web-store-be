<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{

    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.transactions.index')
            ->with([
                'data' =>  $this->transactionService->getAll()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $transaction)
    {
        $transaction = $this->transactionService->getDetailById($request, $transaction);
        return view('pages.transactions.show')
            ->with(["data" => $transaction]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $transaction)
    {
        $product = $this->transactionService->getById($request, $transaction);
        if ($product) {
            return view('pages.transactions.edit')
                ->with([
                    'data' => $product
                ]);
        }
        return redirect()->route('transactions.index')
            ->with('err', __('message.wrong'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, string $product)
    {
        if ($this->transactionService->update($request, $product)) {
            return redirect()->route('transactions.index')
                ->with('suc', __('message.success.update'));
        }
        return redirect()->route('transactions.index')
            ->with('err', __('message.wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $product)
    {
        if ($this->transactionService->delete($request, $product)) {
            return redirect()->route('transactions.index')
                ->with('suc', __('message.success.delete'));
        }
        return redirect()->route('transactions.index')
            ->with('err', __('message.wrong'));
    }

    /**
     * Set the status of specified Transaction.
     */
    public function setStatus(TransactionRequest $request, string $transaction)
    {
        if ($this->transactionService->updateStatus($request, $transaction)) {
            return redirect()->route('transactions.index')
                ->with('suc', __('message.success.update'));
        }
        return redirect()->route('transactions.index')
            ->with('err', __('message.wrong'));
    }
}
