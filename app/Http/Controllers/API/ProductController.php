<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $type = $request->input('type');
        $priceFrom = $request->input('pricefrom');
        $priceTo = $request->input('priceto');
        $orderBy = $request->input('orderby');
        $limit = $request->input('limit', 10);

        $data = Product::with('galleries')
            ->when(!$this->is_null($name), function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when(!$this->is_null($type), function ($query) use ($type) {
                return $query->where('type', 'like', '%' . $type . '%');
            })
            ->when(!$this->is_null($priceFrom), function ($query) use ($priceFrom) {
                return $query->where('price', '>', $priceFrom);
            })
            ->when(!$this->is_null($priceTo), function ($query) use ($priceTo) {
                return $query->where('price', '<', $priceTo);
            })
            ->when(!$this->is_null($orderBy), function ($query) use ($orderBy) {
                return $query->orderBy($orderBy);
            }, function ($query) {
                $query->orderBy('name');
            })
            ->paginate($limit);

        return response()->json(
            ApiFormatter::success($data, 'Data Produk Berhasil diambil!')
        );
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
