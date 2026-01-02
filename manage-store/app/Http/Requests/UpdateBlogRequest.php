<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nameBlog'   => 'required|max:255',
            'idBlog'     => 'required|max:255',
            'imageBlog' => 'nullable',
            'categoryBlog' => 'required',
            'descriptionBlog' => 'required',
            'statusBlog' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'nameBlog.required' => 'The Blog name is required.',
            'nameBlog.max'      => 'The Blog name may not be greater than 255 characters.',
            'idBlog.required'   => 'The Blog ID is required.',
            'idBlog.max'        => 'The Blog ID may not be greater than 255 characters.',
            'idBlog.unique'     => 'The Blog ID has already been taken.',
            'descriptionBlog.required' => 'The Blog description is required.'
        ];
    }
}