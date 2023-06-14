<?php

namespace App\Http\Requests;

use App\Contracts\ValidationRulesInterface;

class ProductUpdate implements ValidationRulesInterface
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            // 'slug' => 'unique|max:150',
            'type' => 'required|max:50',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
    }
}
