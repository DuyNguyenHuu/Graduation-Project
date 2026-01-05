<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function login($email, $password)
    {
        if (
            Auth::attempt(['email' => $email, 'password' => $password]) &&
            Auth::user()->Status == 1 &&
            Auth::user()->ROLE == 1
        ) {
            request()->session()->regenerate();
            return true;
        }

        return false;
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    public function getUsers($request)
    {
        $query = DB::table('users');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('Phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->filled('role')) {
            $query->where('ROLE', $request->role);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        return $query->orderBy('Status', 'desc')
            ->orderBy('ROLE', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->all());
    }

    public function getUserById($idUser)
    {
        return DB::table('users')->where('IdUser', $idUser)->first();
    }

    public function updateUser($idUser, $data)
    {
        return DB::table('users')->where('IdUser', $idUser)->update([
            'Status' => $data['status'],
            'ROLE' => $data['role'],
            'updated_at' => now()
        ]);
    }
}