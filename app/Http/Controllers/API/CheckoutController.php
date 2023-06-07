<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();
            $data = $request->except('transaction_details');
            $data['uuid'] = "TRX" . date('Ymd') . mt_rand(0001, 9999);

            $transaction = Transaction::create($data);

            foreach ($request->transaction_details as $product_id) {

                $product = Product::findOrFail($product_id);

                $details[] = new TransactionDetail([
                    'transactions_id' => $transaction->id,
                    'products_id' => $product->id,
                ]);

                $product->decrement('quantity');
                $product->save();
            }

            $transaction->details()->saveMany($details);

            DB::commit();

            return response()->json(
                ApiFormatter::success($transaction, 'Transaksi Berhasil!', 201)
            );
        } catch (ModelNotFoundException $th) {
            DB::rollBack();
            $this->logError($request, $th);
            return response()->json(
                ApiFormatter::error("Produk {$product_id} tidak ada!", 404)
            );
        } catch (Exception $th) {
            //throw $th;
            DB::rollBack();
            $this->logError($request, $th);
            return response()->json(
                ApiFormatter::error($th->getMessage())
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
