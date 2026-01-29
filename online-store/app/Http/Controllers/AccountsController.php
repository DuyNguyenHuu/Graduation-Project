<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        return view('content.authentication.login');
    }

    public function login(LoginRequest $request)
    {
        $success = $this->accountService->login([
            'email'    => $request->loginEmail,
            'password' => $request->loginPassword,
        ], $request, $request->boolean('remember'));

        if ($success) {
            return redirect()->route('home');
        }

        return back()->withErrors(['error' => 'Invalid email, password or permission denied.'])
                     ->onlyInput('loginEmail');
    }

    public function register(RegisterRequest $request)
    {
        $this->accountService->register($request->validated());
        return redirect()->route('login')
            ->with('success', 'Register successfully!');
    }

    public function logout(Request $request)
    {
        $this->accountService->logout($request);
        return redirect('/')->with('success', 'Logout successfully!');
    }

    public function changePasswordForm()
    {
        return view('content.authentication.changepassword');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $this->accountService->changePassword($user, $request->new_password);

        return redirect()->route('login')
            ->with('success', 'Đổi mật khẩu thành công!');
    }
}