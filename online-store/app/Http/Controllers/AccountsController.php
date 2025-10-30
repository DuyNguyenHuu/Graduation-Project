<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AccountsController extends Controller
{
    public function index(){
        return view('content.authentication.login');
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'loginEmail' => 'required|email',
            'loginPassword' => [
                'required',
                'min:8',
                "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?!.*[^A-Za-z0-9].*[^A-Za-z0-9]).{8,}$/"
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('loginEmail');
        $password = $request->input('loginPassword');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Tạo lại session để tránh session fixation
            $request->session()->regenerate();

            // Chuyển hướng đến trang chủ
            return redirect()->route('home');
        }

        return back()->withErrors([
            'error' => 'Email hoặc mật khẩu không đúng',
        ])->onlyInput('loginEmail');
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'registerName' => 'required|string|max:255',
            'registerEmail' => 'required|email|unique:users,email',
            'registerPhone' => 'required|string|unique:users,phone',
            'registerPassword' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
                'confirmed',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->Name = $request->input('registerName');
        $user->Email = $request->input('registerEmail');
        $user->Phone = $request->input('registerPhone');

        // Mã hóa mật khẩu bằng cách sử dụng Hash::make
        $user->Password = Hash::make($request->input('registerPassword'));

        $user->ROLE = 0;
        $user->save();

        session()->flash('success', 'Đăng ký thành công, vui lòng đăng nhập!');
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}