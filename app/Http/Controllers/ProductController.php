<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.products.index')->with([
            'data' => $this->productService->getAll()
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
        if ($this->productService->save($request)) {
            return redirect()->route('products.index')->with('suc', __('message.success.create'));
        }
        return redirect()->route('products.index')->with('err', __('message.wrong'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $product)
    {
        $product = $this->productService->getById($request, $product);
        if ($product) {
            return view('pages.products.edit')->with([
                'item' => $product
            ]);
        }
        return redirect()->back()->with(['err' => __('message.wrong')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $product)
    {
        if ($this->productService->update($request, $product)) {
            return redirect()->route('products.index')->with('suc', __('message.success.update'));
        }
        return redirect()->route('products.index')->with('err', __('message.wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $product)
    {
        if ($this->productService->delete($request, $product)) {
            return redirect()->route('products.index')->with('suc', __('message.success.delete'));
        }
        return redirect()->route('products.index')->with('err', __('message.wrong'));
    }

    /**
     * Display specified resource base on the product ID.
     */
    public function gallery(Request $request, string $product)
    {
        $product = $this->productService->getById($request, $product);
        if ($product) {
            return view('pages.products.gallery')->with([
                'data' => $product
            ]);
        }
        return redirect()->back()->with(['err' => __('message.wrong')]);
    }
}
