<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function loginPage()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->emailLogin;
        $password = $request->passwordLogin;

        if ($this->userService->login($email, $password)) {
            return redirect()->route('dashBoard');
        }

        return back()->withErrors([
            'error' => 'Invalid email, password or permission denied.'
        ])->onlyInput('emailLogin');
    }

    public function logout(Request $request)
    {
        $this->userService->logout();
        return redirect('/login')->with('success', 'You have logged out successfully!');
    }

    public function index(Request $request)
    {
        $getUser = $this->userService->getUsers($request);
        return view('users.indexUser', compact('getUser'));
    }

    public function edit($idUser)
    {
        $getUserById = $this->userService->getUserById($idUser);
        return view('users.updateUser', compact('getUserById'));
    }

    public function update(UpdateUserRequest $request, $idUser)
    {
        $this->userService->updateUser($idUser, $request->validated());

        return redirect('/users')->with('success', 'User updated successfully!');
    }
}