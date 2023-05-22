<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'transactions_id', 'products_id'
    ];
    protected $hidden = [];

    public function details()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id');
    }

    public function product()
    {
        return $this->belongsTo(Transaction::class, 'products_id');
    }
}
