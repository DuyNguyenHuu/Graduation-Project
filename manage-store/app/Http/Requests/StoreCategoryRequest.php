<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameCategory'   => 'required|string|max:255',
            'idCategory'     => 'required|string|max:255|unique:categories,IdCategory',
            'statusCategory' => 'required|in:0,1',
        ];
    }
}