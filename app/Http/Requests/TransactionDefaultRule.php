<?php

namespace App\Http\Requests;

use App\Contracts\ValidationRulesInterface;

class TransactionDefaultRule implements ValidationRulesInterface
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'number' => 'required|max:255',
            'address' => 'required|max:255',
        ];
    }
}
