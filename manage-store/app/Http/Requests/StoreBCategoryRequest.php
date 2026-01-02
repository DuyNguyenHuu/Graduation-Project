<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameBCategory'   => 'required|string|max:255',
            'idBCategory'     => 'required|string|max:255|unique:bcategories,IdBCategory',
            'statusBCategory' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'nameBCategory.required' => 'The BCategory name is required.',
            'nameBCategory.string'   => 'The BCategory name must be a string.',
            'nameBCategory.max'      => 'The BCategory name may not be greater than 255 characters.',
            'idBCategory.required'   => 'The BCategory ID is required.',
            'idBCategory.string'     => 'The BCategory ID must be a string.',
            'idBCategory.max'        => 'The BCategory ID may not be greater than 255 characters.',
            'idBCategory.unique'     => 'The BCategory ID has already been taken.',
        ];
    }
}