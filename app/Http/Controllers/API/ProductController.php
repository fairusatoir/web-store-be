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
        $priceFrom = $request->input('pricefrom', 0);
        $priceTo = $request->input('priceto', 999999999999999999);
        $orderBy = $request->input('orderby', 'name');
        $limit = $request->input('limit', '10');

        $data = Product::select('*')
            ->when(!is_null($name), function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when(!is_null($type), function ($query) use ($type) {
                return $query->where('type', 'like', '%' . $type . '%');
            })
            ->where('price', '>', $priceFrom)
            ->where('price', '<', $priceTo)
            ->with('galleries')
            ->orderBy($orderBy)
            ->paginate($limit);

        return ApiFormatter::success($data, 'Data Produk Berhasil diambil!');
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
