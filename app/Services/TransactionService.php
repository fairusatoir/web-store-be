<?php

namespace App\Services;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get All Products
     *
     * @return Collection Product
     */
    public function getAll(): Collection
    {
        return $this->transaction->all();
    }

    /**
     * Get Product By ID
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Transaction
     */
    public function getById(Request $request, String $id): ?Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->transaction->find($id);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Transaction]",
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
     * @return Transaction
     */
    public function save(Request $request): ?Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Save Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->transaction->create($request->all());

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
    public function update(Request $request, String $id): ?Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Update Product]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->transaction->updateById($request->all(), $id);

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

            $transaction = $this->transaction->delete($id);
            if ($transaction) {
                // $this->productGalleryService->deleteByProduct($request, $id);
            }

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Delete Product]",
                [
                    'response' => $transaction,
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
