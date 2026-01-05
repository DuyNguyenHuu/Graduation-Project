<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emailLogin' => 'required|email',
            'passwordLogin' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'emailLogin.required' => 'Please enter email.',
            'emailLogin.email' => 'Invalid email format.',
            'passwordLogin.required' => 'Please enter password.',
            'passwordLogin.min' => 'Password must be at least 8 characters.',
            'passwordLogin.regex' => 'Password must contain uppercase, lowercase, number and special character.',
        ];
    }
}