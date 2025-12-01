<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Hiển thị form login
    public function loginPage()
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

    public function index(Request $request){
        $query = DB::table('users');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('Name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('Phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('Status', $request->status);
        }

        if ($request->role) {
            $query->where('ROLE', $request->role);
        }

        if ($request->from_date){
            $query->where('created_at', '>=', $request->from_date);
        }
        if ($request->to_date){
            $query->where('created_at', '<=', $request->to_date);
        }

        $getUser = $query->orderBy('Status', 'desc')
                        ->orderBy('ROLE', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10)->appends($request->all());

        return view('users.indexUser', compact('getUser'));
    }

    public function edit($idUser){
        $getUserById = DB::table('users')->where('IdUser', $idUser)->first();
        return view('users.updateUser', compact('getUserById'));
    }

    public function update($idUser){
        DB::table('users')->where('IdUser', $idUser)->update([
            'Status' => request('status'),
            'ROLE' => request('role'),
            'updated_at' => now()
        ]);
        return redirect('/users')->with('success', 'User updated successfully!');
    }
}