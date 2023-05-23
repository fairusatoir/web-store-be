<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
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
            $file = $request->file('photo');

            $extension = $file->getClientOriginalExtension();
            $fileName = 'photo_product_' . Str::random(10) . '.' . $extension;
            $directory = 'assets/product/' . $request->products_id;

            // Membuat direktori jika belum ada
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            $path = $file->storeAs($directory, $fileName, 'public');

            $data = $request->all();
            $data['photo'] = $path;
            ProductGallery::create($data);
        } catch (Exception $e) {
            $this->logError($request, $e);
        }
        return redirect()->route('product-galleries.index');
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
    public function destroy(Request $request, string $id)
    {
        try {
            $item = ProductGallery::findOrFail($id);
            $item->delete();
        } catch (Exception $e) {
            $this->logError($request, $e);
        }
        return redirect()->route('product-galleries.index');
    }
}
