<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameSubCategory' => 'required|string|max:255',
            'statusSubCategory' => 'required|in:0,1',
            'nameCategory' => 'required|exists:categories,IdCategory',

            'idSubCategory' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}