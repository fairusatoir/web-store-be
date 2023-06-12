<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckoutRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckoutRequest $request)
    {
        try {
            Log::info(
                "[BEGIN][Store Checkout Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all()
                ]
            );

            DB::beginTransaction();
            $data = $request->except('transaction_detail');
            $trxNumber = Transaction::whereDate('updated_at', Carbon::today())->count();
            $data['uuid'] = "TRX" . date('Ymd') . str_pad($trxNumber, 4, '0', STR_PAD_LEFT);

            $transaction = Transaction::create($data);

            foreach ($request->transaction_detail as $slug) {

                $product = Product::where('slug', $slug)->firstOrFail();

                $details[] = new TransactionDetail([
                    'transactions_id' => $transaction->id,
                    'products_id' => $product->id,
                ]);

                $product->decrement('quantity');
                $product->save();
            }

            $transaction->details()->saveMany($details);

            DB::commit();

            Log::info(
                "[SUCCESS][Store Checkout Transaction {$data['uuid']}]",
                [
                    'response' => $data,
                ]
            );

            return response()->json(
                ApiFormatter::success($transaction, 'Transaksi Berhasil!', 201),
                201
            );
            // } catch (ModelNotFoundException $e) {
            //     DB::rollBack();
            //     Log::error(
            //         "[ERROR][{$e->getMessage()}]",
            //         [
            //             "execption" => $e,
            //         ],
            //     );
            //     return response()->json(
            //         ApiFormatter::error("Produk tidak tersedia!", 422),
            //         422
            //     );
        } catch (Exception $e) {
            //throw $e;
            DB::rollBack();
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
