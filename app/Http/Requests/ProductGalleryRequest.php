<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductGalleryRequest extends FormRequest
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
        return [
            'products_id' => "required|integer|exists:products,id",
            'photo' => "required|image",
            'is_default' => "boolean"
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->filled('is_default')) {
            $this->merge([
                'is_default' => false, // Nilai default jika tidak ada dalam permintaan
            ]);
        }
    }
}
