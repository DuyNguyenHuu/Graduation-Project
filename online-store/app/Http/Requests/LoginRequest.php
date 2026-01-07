<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'loginEmail' => 'required|email',
            'loginPassword' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'loginEmail.required' => 'Please enter email.',
            'loginEmail.email' => 'Invalid email format.',
            'loginPassword.required' => 'Please enter password.',
            'loginPassword.min' => 'Password must be at least 8 characters.',
            'loginPassword.regex' => 'Password must contain uppercase, lowercase and number.',
        ];
    }
}