<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'registerName'     => 'required|string|max:255',
            'registerEmail'    => 'required|email|unique:users,email',
            'registerPhone'    => 'required|unique:users,phone',
            'registerPassword' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
                'confirmed',
            ],
            'registerPassword_confirmation' => 'required|same:registerPassword',
        ];
    }
    public function messages(): array
    {
        return [
            'registerName.required' => 'Please enter name.',
            'registerEmail.required' => 'Please enter email.',
            'registerEmail.email' => 'Invalid email format.',
            'registerEmail.unique' => 'Email already exists.',
            'registerPhone.required' => 'Please enter phone number.',
            'registerPhone.unique' => 'Phone number already exists.',
            'registerPassword.required' => 'Please enter password.',
            'registerPassword.min' => 'Password must be at least 8 characters.',
            'registerPassword.regex' => 'Password must contain uppercase, lowercase and number.',
            'registerPassword_confirmation.required' => 'Please confirm password.',
            'registerPassword_confirmation.same' => 'Password and confirm password do not match.',
        ];
    }
}