<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Requests\ProductGalleryRequest;

class ProductGalleryController extends Controller
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
        return view('pages.product-galleries.index')->with([
            'data' => ProductGallery::with('products')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product-galleries.create')->with([
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request)
    {
        try {
            $data = $request->all();
            $data['photo'] = $request->file('photo')->store(
                'assets/product',
                'public'
            );
            ProductGallery::create($data);
        } catch (Exception $e) {
            echo "Create new Product fail with error " . $e->getMessage();
        }
        return redirect()->route('product-galleries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGalleryRequest $request, string $id)
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
