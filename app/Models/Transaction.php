<?php

namespace App\Models;

use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'name', 'email', 'number', 'address', 'transaction_total', 'transaction_status'
    ];
    protected $hidden = [];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id');
    }

    /**
     * Update Data Transaction
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return Transaction
     */
    public function updateById(array $data, String $id): Transaction
    {
        $item = $this->findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function updateStatus(String $status, String $id): Transaction
    {
        $item = $this->findOrFail($id);
        $item->transaction_status = $status;
        $item->save();
        return $item;
    }
}
