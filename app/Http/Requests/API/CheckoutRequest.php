<?php

namespace App\Http\Requests\API;

use Exception;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'number' => 'required|max:255',
            'address' => 'required|max:255',
            'transaction_total' => 'required|integer',
            'transaction_status' => 'nullable|string|in:PENDING,SUCCESS,FAILED',
            'transaction_detail' => 'required|array',
            'transaction_detail.*' => 'string|exists:products,slug',
        ];
    }

    /**
     * Modify the Error message
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not exceed 100 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Invalid email format.',
            'email.max' => 'The email must not exceed 255 characters.',
            'number.required' => 'The number field is required.',
            'number.max' => 'The number must not exceed 255 characters.',
            'address.required' => 'The address field is required.',
            'address.max' => 'The address must not exceed 255 characters.',
            'transaction_total.required' => 'The transaction total field is required.',
            'transaction_total.integer' => 'The transaction total must be an integer.',
            'transaction_status.string' => 'The transaction status must be a string.',
            'transaction_status.in' => 'Invalid transaction status.',
            'transaction_detail.required' => 'The transaction detail field is required.',
            'transaction_detail.array' => 'The transaction detail must be an array.',
            'transaction_detail.*.exists' => 'Invalid product in the transaction detail.',
        ];
    }

    /**
     * Get the Error message
     *
     * @param  mixed $validator
     * @return Exception
     */
    protected function failedValidation(Validator $validator): Exception
    {
        Log::error(
            "[ERROR][Validation failed]",
            [
                "execption" => $validator->errors(),
            ],
        );
        throw new HttpResponseException(response()->json(
            ApiFormatter::error('Validation failed', 422, $validator->errors()),
            422
        ));
    }
}
