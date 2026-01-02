<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameSubCategory' => 'required|string|max:255',
            'idSubCategory'   => 'required|string|max:255',
            'idCategory'      => 'required|exists:categories,IdCategory',
            'statusSub'       => 'required|in:0,1',
        ];
    }
}