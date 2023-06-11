<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            Log::info(
                "[BEGIN][Get All Transactions]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all()
                ]
            );

            $transactions = Transaction::with('details.product')->paginate(10);

            Log::info(
                "[SUCCESS][Get All Transactions]",
                [
                    'response' => $transactions,
                ]
            );

            return response()->json(
                ApiFormatter::success($transactions, "Data Transaksi berhasil diambil!")
            );
        } catch (Exception $e) {
            Log::error(
                "[ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );

            return response()->json(
                ApiFormatter::error($e->getMessage())
            );
        }
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
    public function show(Request $request, string $trx)
    {
        try {
            Log::info(
                "[BEGIN][Get {$trx} Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all()
                ]
            );

            $transaction = Transaction::with('details.product')->where('uuid', $trx)->get();

            Log::info(
                "[SUCCESS][Get {$trx} Transaction]",
                [
                    'response' => $transaction,
                ]
            );

            return response()->json(
                ApiFormatter::success($transaction, "Data Transaksi {$trx} berhasil diambil!")
            );
        } catch (Exception $e) {
            Log::error(
                "[ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );

            return response()->json(
                ApiFormatter::error($e->getMessage())
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
