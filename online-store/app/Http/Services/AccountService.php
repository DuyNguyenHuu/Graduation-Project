<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function login(array $credentials, $request)
    {
        if (Auth::attempt($credentials) && Auth::user()->Status == 1) {
            $request->session()->regenerate();
            session()->put('payment_method', 'cod');
            session()->forget('coupon');
            return true;
        }
        return false;
    }

    public function register(array $data)
    {
        return User::create([
            'Name'     => $data['registerName'],
            'email'    => $data['registerEmail'],
            'Phone'    => $data['registerPhone'],
            'password' => Hash::make($data['registerPassword']),
            'Status'   => 1,
        ]);
    }

    public function changePassword(User $user, string $newPassword)
    {
        $user->password = Hash::make($newPassword);
        $user->save();
    }

    public function logout($request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}