<?php

namespace App\Http\Requests;

use App\Contracts\ValidationRulesInterface;

class TransactionSetStatus implements ValidationRulesInterface
{
    public function rules(): array
    {
        return [
            'status' => 'required|in:PENDING,SUCCESS,FAILED'
        ];
    }
}
