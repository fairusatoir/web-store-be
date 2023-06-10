<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Helpers\Stringer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            Log::info(
                "[BEGIN][Get All Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all()
                ]
            );

            $name = $request->input('name');
            $type = $request->input('type');
            $priceFrom = $request->input('pricefrom');
            $priceTo = $request->input('priceto');
            $orderBy = $request->input('orderby');
            $limit = $request->input('limit', 10);

            $data = Product::with('galleries')
                ->when(!Stringer::is_null($name), function ($query) use ($name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->when(!Stringer::is_null($type), function ($query) use ($type) {
                    return $query->where('type', 'like', '%' . $type . '%');
                })
                ->when(!Stringer::is_null($priceFrom), function ($query) use ($priceFrom) {
                    return $query->where('price', '>', $priceFrom);
                })
                ->when(!Stringer::is_null($priceTo), function ($query) use ($priceTo) {
                    return $query->where('price', '<', $priceTo);
                })
                ->when(!Stringer::is_null($orderBy), function ($query) use ($orderBy) {
                    return $query->orderBy($orderBy);
                }, function ($query) {
                    $query->orderBy('name');
                })
                ->paginate($limit);

            Log::info(
                "[END][Get All Product]",
                [
                    'response' => $data,
                ]
            );

            return response()->json(
                ApiFormatter::success($data, 'Data Produk Berhasil diambil!')
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
    public function show(Request $request, string $slug)
    {
        try {
            Log::info(
                "[BEGIN][Show {$slug}]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all()
                ]
            );

            $product = Product::where('slug', $slug)->get();
            if (!$product) {
                throw new ModelNotFoundException("Product {$slug} not Found!");
            }

            Log::info(
                "[END][Show {$slug}]",
                [
                    'response' => $product,
                ]
            );

            return response()->json(
                ApiFormatter::success($product, "Data {$slug} Berhasil diambil!")
            );
        } catch (ModelNotFoundException $e) {
            Log::error(
                "[NOTFOUND][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return response()->json(
                ApiFormatter::error($e->getMessage(), 404)
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
