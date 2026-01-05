<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameProduct' => 'required|string|max:255',
            'idProduct' => 'required|string|max:255',
            'typeProduct' => 'nullable',
            'imageURLProduct' => 'nullable',
            'statusProduct' => 'required',
            'tags' => 'nullable',
            'descriptionProduct' => 'nullable|string',
            'newPriceProduct' => 'required|numeric|min:0',
            'oldPriceProduct' => 'nullable|numeric|min:0',
            'categoryProduct' => 'nullable',
            'subCategoryProduct' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'nameProduct.required' => 'Please enter product name.',
            'nameProduct.string' => 'Product name must be a string.',
            'nameProduct.max' => 'Product name must not exceed 255 characters.',
            'idProduct.required' => 'Please enter product ID.',
            'idProduct.string' => 'Product ID must be a string.',
            'idProduct.max' => 'Product ID must not exceed 255 characters.',
            'statusProduct.required' => 'Please select product status.',
            'descriptionProduct.string' => 'Description must be a string.',
            'newPriceProduct.required' => 'Please enter new price.',
            'newPriceProduct.numeric' => 'New price must be a number.',
            'newPriceProduct.min' => 'New price must be at least 0.',
            'oldPriceProduct.numeric' => 'Old price must be a number.',
            'oldPriceProduct.min' => 'Old price must be at least 0.',
        ];
    }
}