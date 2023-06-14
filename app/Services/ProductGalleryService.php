<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProductGalleryService
{

    protected $image;
    protected $productGallery;

    public function __construct(ProductGallery $productGallery, ImageService $image)
    {
        $this->image = $image;
        $this->productGallery = $productGallery;
    }

    /**
     * Get All Image Product Gallery
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->productGallery->with('products')->get();
    }

    /**
     * save new Image Product Gallery
     *
     * @param  mixed $request
     * @return ProductGallery
     */
    public function save(Request $request): ProductGallery
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Upload Image Product Gallery]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $data = $request->all();
            $data['photo'] = $this->image->store($request);

            $item = $this->productGallery->create($data);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Upload Image Product Gallery]",
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
     * Delete Image Product Gallery
     *
     * @param  mixed $request
     * @param  mixed $id Id Image
     * @return bool
     */
    public function delete(Request $request, string $id): bool
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Delete Image Product Gallery]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->productGallery->findOrFail($id);
            $item->delete();

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Delete Image Product Gallery]",
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

    /**
     * Delete Image Product Gallery by Id Product
     *
     * @param  mixed $request
     * @param  mixed $id Id Product
     * @return bool
     */
    public function deleteByProduct(Request $request, string $id): bool
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Delete Image Gallery By Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->productGallery->where('products_id', $id)->delete();

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Delete Image Gallery By Product]",
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
