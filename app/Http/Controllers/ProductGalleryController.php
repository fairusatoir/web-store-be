<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductGalleryRequest;
use App\Services\ProductGalleryService;
use App\Services\ProductService;

class ProductGalleryController extends Controller
{

    private $productService;
    private $productGalleryService;

    public function __construct(ProductService $productService, ProductGalleryService $productGalleryService)
    {
        $this->productService = $productService;
        $this->productGalleryService = $productGalleryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product-galleries.index')->with([
            'data' => $this->productGalleryService->getAll()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product-galleries.create')->with([
            'products' => $this->productService->getAll()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request)
    {
        if ($this->productGalleryService->save($request)) {
            return redirect()->route('product-galleries.index')->with('suc', __('message.success.create'));
        }
        return redirect()->route('product-galleries.index')->with('err', __('message.wrong'));
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
        if ($this->productGalleryService->delete($request, $id)) {
            return redirect()->route('product-galleries.index')->with('suc', __('message.success.delete'));
        }
        return redirect()->route('product-galleries.index')->with('suc', __('message.wrong'));
    }
}
