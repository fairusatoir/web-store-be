<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.transactions.index')->with([
            'data' => Transaction::orderBy('created_at', 'desc')->get()
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
    public function show(string $id)
    {
        return view('pages.transactions.show')->with([
            "data" => Transaction::with('details.product')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.transactions.edit')->with([
            'data' => Transaction::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, string $id)
    {
        try {
            $data = $request->all();
            $item = Transaction::findOrFail($id);
            $item->update($data);
        } catch (Exception $e) {
            $this->logError($request, $e);
        }
        return redirect()->route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $item = Transaction::findOrFail($id);
            $item->delete();
        } catch (Exception $e) {
            $this->logError($request, $e);
        }
        return redirect()->route('transactions.index');
    }

    /**
     * Set the status of specified resource.
     */
    public function setStatus(TransactionRequest $request, string $id)
    {
        try {
            $item = Transaction::findOrFail($id);
            $item->transaction_status = $request->status;
            $item->save();
        } catch (Exception $e) {
            $this->logError($request, $e);
        }
        return redirect()->route('transactions.index');
    }
}
