<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Exception;

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
            echo "Create new Product fail with error " . $e->getMessage();
        }
        return redirect()->route('products.index');
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
            echo "Create new Product fail with error " . $e->getMessage();
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Product::findOrFail($id);
            $item->delete();
        } catch (Exception $e) {
            echo "Create new Product fail with error " . $e->getMessage();
        }
        return redirect()->route('products.index');
    }
}
