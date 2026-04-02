<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;

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

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $providerId = $socialUser->getId();
            $email = $socialUser->getEmail()
                ?? $providerId . '@' . $provider . '.local'; // fallback
            $name = $socialUser->getName() ?? 'User';

            // 1. Tìm theo provider
            $user = DB::table('users')
                ->where('provider', $provider)
                ->where('provider_id', $providerId)
                ->first();

            if (!$user) {
                // 2. Tìm theo email
                $user = DB::table('users')
                    ->where('email', $email)
                    ->first();

                if ($user) {
                    // update liên kết
                    DB::table('users')
                        ->where('IdUser', $user->IdUser)
                        ->update([
                            'provider' => $provider,
                            'provider_id' => $providerId,
                            'updated_at' => now()
                        ]);
                } else {
                    // 3. tạo mới
                    $userId = DB::table('users')->insertGetId([
                        'Name' => $name,
                        'email' => $email,
                        'provider' => $provider,
                        'provider_id' => $providerId,
                        'password' => null,
                        'ROLE' => 0,
                        'Status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ], 'IdUser'); // 👈 QUAN TRỌNG

                    $user = DB::table('users')
                        ->where('IdUser', $userId)
                        ->first();
                }
            }

            // 4. login
            Auth::loginUsingId($user->IdUser);

            return redirect()->route('home');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Đăng nhập Google thất bại: ' . $e->getMessage()]);
        }
    }
}