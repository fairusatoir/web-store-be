<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Http\Requests\ProductDefaultRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'products.update' => new ProductUpdate(),
            default => new ProductDefaultRule(),
        };

        return $validator->rules();
    }

    public function messages()
    {
        return [
            'name.required'     => __('validation.required', ['attribute' => 'NAME']),
            'name.unique'     => __('validation.unique', ['attribute' => 'NAME']),
            'name.max'          => __('validation.max_digits', ['attribute' => 'NAME', 'max' => 100]),
            // 'slug.unique'     => __('validation.wrong', ['attribute' => 'NAME']),
            // 'slug.max'          => __('validation.wrong', ['attribute' => 'NAME']),
            'type.required'     => __('validation.required', ['attribute' => 'TYPE']),
            'type.max'          => __('validation.wrong', ['attribute' => 'TYPE']),
            'description.required' => __('validation.required', ['attribute' => 'DESCRIPTION']),
            'description.max'   => __('validation.max_digits', ['attribute' => 'DESCRIPTION', 'max' => 255]),
            'price.required'    => __('validation.required', ['attribute' => 'PRICE']),
            'price.numeric'     => __('validation.numeric', ['attribute' => 'PRICE']),
            'quantity.required' => __('validation.required', ['attribute' => 'QUANTITY']),
            'quantity.numeric'  => __('validation.numeric', ['attribute' => 'QUANTITY']),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->filled('slug') ? $this->input('slug') : Str::slug($this->input('name')),
        ]);
    }
}
