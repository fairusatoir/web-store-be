<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Helpers\Stringer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    private $product;
    private $str;

    public function __construct(Product $product, Stringer $str)
    {
        $this->product = $product;
        $this->str = $str;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.products.index')->with([
            'data' => $this->product->all()
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
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Update Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->product->createProduct($request->all());

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Update Product]",
                [
                    'response' => $item,
                ]
            );
            return redirect()->route('products.index')->with('suc', __('message.success.update'));
        } catch (ModelNotFoundException $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return redirect()->route('products.index')->with('err', __('message.wrong'));
        }
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
    public function edit(string $product)
    {
        try {
            $product = $this->product->findOrFail($product);
            return view('pages.products.edit')->with([
                'item' => $product
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with([
                'err' => __('message.wrong')
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $product)
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Update Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );
            $itemUpdate = $this->product->updateById($request->all(), $product);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Update Product]",
                [
                    'response' => $itemUpdate,
                ]
            );
            return redirect()->route('products.index')->with('suc', __('message.success.update'));
        } catch (ModelNotFoundException $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return redirect()->route('products.index')->with('err', __('message.wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $product)
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Delete Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $this->product->deleteById($product);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Delete Product]",
                []
            );

            return redirect()->route('products.index')->with('suc', __('message.success.delete'));
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return redirect()->route('products.index')->with('err', __('message.wrong'));
        }
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
            $this->logError($request, $e);
        }
    }
}
