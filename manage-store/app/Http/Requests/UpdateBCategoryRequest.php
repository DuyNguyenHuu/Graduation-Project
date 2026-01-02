<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameBCategory' => 'required|string|max:255',
            'statusBCategory' => 'required',
            'idBCategory' => [
                'required',
                'string',
                'max:255',
            ],
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
        ];
    }
}