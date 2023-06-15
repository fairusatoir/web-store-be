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
    public function getAll($limit = null): Collection
    {
        return $this->transaction
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
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
     * Get Transaction By Status
     *
     * @param  mixed $request
     * @param  mixed $status
     * @return Transaction
     */
    public function getByStatus(Request $request, String $status): Transaction
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $data = $this->transaction->where('transaction_status', $status);

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Transaction]",
                [
                    'response' => $data,
                ]
            );
            return $data;
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
     * Get Transaction By Status
     *
     * @param  mixed $request
     * @param  mixed $status
     * @return Transaction
     */
    public function getCountByStatus(Request $request, String $status): int
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $data = $this->transaction->where('transaction_status', $status)->count();

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Transaction]",
                [
                    'response' => $data,
                ]
            );
            return $data;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return 0;
        }
    }

    /**
     * Get Amount income - Only success transaction
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Integer Sum of amount success transaction
     */
    public function sumIncome(Request $request)
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Transaction Income]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $income = $this->transaction->sumSuccessTransaction();

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Transaction Income]",
                [
                    'response' => $income,
                ]
            );
            return $income;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );

            return 0;
        }
    }

    /**
     * Get count all transaction
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Integer Sum of amount success transaction
     */
    public function countTransaction(Request $request): int
    {
        try {
            Log::info(
                "[{$request->header('x-request-id')}][BEGIN][Get Total Amount Transaction]",
                [
                    'headers' => $request->header(),
                    'body' => $request->all(),
                ]
            );

            $count = $this->transaction->count();

            Log::info(
                "[{$request->header('x-request-id')}][SUCCESS][Get Total Amount Transaction]",
                [
                    'response' => $count,
                ]
            );
            return $count;
        } catch (Exception $e) {
            Log::error(
                "[{$request->header('x-request-id')}][ERROR][{$e->getMessage()}]",
                [
                    "execption" => $e,
                ],
            );
            return 0;
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
