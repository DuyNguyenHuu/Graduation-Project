<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameCategory'   => 'required|string|max:255',
            'statusCategory' => 'required|in:0,1',
            'idCategory' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}