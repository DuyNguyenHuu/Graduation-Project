<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function auzhorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
                'confirmed',
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ];
    }
    public function messages(): array
    {
        return [
            'old_password.required' => 'Please enter old password.',
            'new_password.required' => 'Please enter new password.',
            'new_password.min' => 'Password must be at least 8 characters.',
            'new_password.regex' => 'Password must contain uppercase, lowercase and number.',
            'new_password_confirmation.required' => 'Please confirm new password.',
            'new_password_confirmation.same' => 'New password and confirm new password do not match.',
        ];
    }
}