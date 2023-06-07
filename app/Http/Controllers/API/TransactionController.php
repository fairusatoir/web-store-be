<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(
                ApiFormatter::success(
                    Transaction::with('details.product')->paginate(10),
                    "Data Transaksi berhasil diambil"
                )
            );
        } catch (Exception $th) {
            return response()->json(
                ApiFormatter::error($th->getMessage())
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
    public function show(string $id)
    {
        try {
            return response()->json(
                ApiFormatter::success(
                    Transaction::with('details.product')->findOrFail($id),
                    "Data Transaksi berhasil diambil"
                )
            );
        } catch (ModelNotFoundException $th) {
            return response()->json(
                ApiFormatter::error("Produk tidak ada!", 404)
            );
        } catch (Exception $th) {
            return response()->json(
                ApiFormatter::error($th->getMessage())
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
