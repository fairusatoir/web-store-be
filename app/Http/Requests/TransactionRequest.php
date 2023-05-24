<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $validator = match ($this->route()->getName()) {
            'transactions.set-status' => new TransactionSetStatus(),
            default => new TransactionDefaultRule(),
        };

        return $validator->rules();
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            // 'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}
