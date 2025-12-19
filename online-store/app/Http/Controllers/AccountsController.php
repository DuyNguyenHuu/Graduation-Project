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

        if (Auth::attempt(['email' => $email, 'password' => $password]) && Auth::user()->Status == 1) {
            // Tạo lại session để tránh session fixation
            $request->session()->regenerate();
            session()->forget('cart');
            session()->forget('coupon');

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
        $user->password = Hash::make($request->input('registerPassword'));

        $user->Status = 1;
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

    public function changePasswordForm(){
        return view('content.authentication.changepassword');
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => [
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Current password is incorrect!'])->withInput();
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('login')->with('success', 'Password changed successfully!');
    }
}