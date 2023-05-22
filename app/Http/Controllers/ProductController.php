<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.products.index')->with([
            'data' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            Product::create($data);
        } catch (Exception $e) {
            $this->logError($request->header('X-Request-ID'), $e);
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        return view('pages.products.edit')->with([
            'item' => Product::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($request->name);
            $item = Product::findOrFail($id);
            $item->update($data);
        } catch (Exception $e) {
            $this->logError($request->header('X-Request-ID'), $e);
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $item = Product::findOrFail($id);
            $item->delete();

            ProductGallery::where('products_id', $id)->delete();
        } catch (Exception $e) {
            $this->logError($request->header('X-Request-ID'), $e);
        }
        return redirect()->route('products.index');
    }

    /**
     * Display specified resource base on the product ID.
     */
    public function gallery(Request $request, string $product)
    {
        try {
            return view('pages.products.gallery')->with([
                'product' => Product::findOrFail($product),
                'data' => ProductGallery::with('products')
                    ->where('products_id', $product)
                    ->get()
            ]);
        } catch (Exception $e) {
            $this->logError($request->header('X-Request-ID'), $e);
        }
    }
}
