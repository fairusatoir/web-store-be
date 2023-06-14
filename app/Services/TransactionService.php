<?php

namespace App\Services;

use App\Http\Requests\TransactionRequest;
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
     * Get All Transactions
     *
     * @return Collection Transaction
     */
    public function getAll(): Collection
    {
        return $this->transaction->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get Transaction By ID
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

            $item = $this->transaction->with('details.Transaction')->findOrFail($id);

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
     * Get Transaction By ID with Detail and Transaction
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Transaction
     */
    public function getDetailById(Request $request, String $id): ?Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->transaction->with('details.product')->findOrFail($id);

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
     * Save Transaction
     *
     * @param  mixed $request
     * @return Transaction
     */
    public function save(TransactionRequest $request): ?Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Save Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->transaction->create($request->all());

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Save Transaction]",
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
     * Update Transaction
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Transaction
     */
    public function update(Request $request, String $id): ?Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Update Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $item = $this->transaction->updateById($request->all(), $id);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Update Transaction]",
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
     * Soft Delete Transaction
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return bool
     */
    public function delete(Request $request, String $id): bool
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Delete Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $transaction = $this->transaction->findOrFail($id)->delete();

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Delete Transaction]",
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

    /**
     * Update Status Transaction
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return bool
     */
    public function updateStatus(Request $request, String $id): bool
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Update Status Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $transaction = $this->transaction->updateStatus($request->status, $id);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Update Status Transaction]",
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
