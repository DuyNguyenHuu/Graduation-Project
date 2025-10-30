<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Hiển thị form login
    public function index()
    {
        return view('login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
{
        // 🔹 Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'emailLogin' => 'required|email',
            'passwordLogin' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=[^!@#$%^&*()_+\[\]{};:\'",.<>?\/\\\\|`~]*[!@#$%^&*()_+\[\]{};:\'",.<>?\/\\\\|`~][^!@#$%^&*()_+\[\]{};:\'",.<>?\/\\\\|`~]*$).{8,}$/'
            ],
        ], [
            'emailLogin.required' => 'Please enter email.',
            'emailLogin.email' => 'Invalid email format.',
            'passwordLogin.required' => 'Please enter password.',
            'passwordLogin.min' => 'Password must be at least 8 characters.',
            'passwordLogin.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('emailLogin');
        $password = $request->input('passwordLogin');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->ROLE == 1) {
                return redirect()->route('dashBoard');
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'error' => 'Your account does not have permission to access the admin page.',
                ]);
            }
        }

        return back()->withErrors([
            'error' => 'Invalid email or password.',
        ])->onlyInput('emailLogin');
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have logged out successfully!');
    }
}