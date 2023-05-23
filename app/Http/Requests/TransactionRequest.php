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
        switch ($this->route()->getName()) {
            case 'transactions.set-status':
                return [
                    'status' => 'required|in:PENDING,SUCCESS,FAILED'
                ];
            default:
                return [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'number' => 'required|max:255',
                    'address' => 'required|max:255',
                ];
        }
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
