<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'optionProduct' => 'required',
            'subOptionProduct' => 'required',
            'quantityProduct' => 'required|integer|min:1',
            'priceProduct' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'optionProduct.required' => 'Please select an option product.',
            'subOptionProduct.required' => 'Please select a sub-option product.',
            'quantityProduct.required' => 'Quantity is required.',
            'quantityProduct.integer' => 'Quantity must be an integer.',
            'quantityProduct.min' => 'Quantity must be at least 1.',
            'priceProduct.required' => 'Price is required.',
            'priceProduct.numeric' => 'Price must be a number.',
            'priceProduct.min' => 'Price must be at least 0.',
        ];
    }
}