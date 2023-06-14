<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductGallery;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductService
{
    protected $product;
    protected $productGallery;
    protected $str;

    /**
     * __construct
     *
     * @param  mixed $product
     * @param  mixed $str
     * @return void
     */
    public function __construct(Product $product, ProductGallery $productGallery, Str $str)
    {
        $this->product = $product;
        $this->productGallery = $productGallery;
        $this->str = $str;
    }

    /**
     * Get All Products
     *
     * @return Collection Product
     */
    public function getAll(): Collection
    {
        return $this->product->all();
    }


    /**
     * Get Product And All Gallery by Id
     *
     * @param  mixed $id
     * @return array
     */
    public function getProductAndGallery(Request $request, String $id): Collection
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Product and All Gallery]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->product->with('galleries')->findOrFail($id);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Product]",
                [
                    'response' => $item,
                ]
            );
            return $item;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return null;
        }
    }

    /**
     * Get Product By ID
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Product
     */
    public function getById(Request $request, String $id): ?Product
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->product->find($id);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Product]",
                [
                    'response' => $item,
                ]
            );
            return $item;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return null;
        }
    }

    /**
     * Save Product
     *
     * @param  mixed $request
     * @return Product
     */
    public function save(Request $request): Product
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Save Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->product->create($request->all());

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Save Product]",
                [
                    'response' => $item,
                ]
            );

            return $item;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return false;
        }
    }

    /**
     * Update Product
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Product
     */
    public function update(Request $request, String $id): Product
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Update Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->product->updateById($request->all(), $id);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Update Product]",
                [
                    'response' => $item,
                ]
            );

            return $item;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return false;
        }
    }

    /**
     * Soft Delete Product
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return bool
     */
    public function delete(Request $request, String $id): bool
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Delete Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->product->deleteById($id);
            if ($item) {
                $this->productGallery->where('products_id', $id)->delete();
            }

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Delete Product]",
                [
                    'response' => $item,
                ]
            );

            return true;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return false;
        }
    }
}
