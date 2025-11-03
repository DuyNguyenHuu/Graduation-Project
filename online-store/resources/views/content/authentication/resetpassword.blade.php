@extends('layouts.template')
@section('content')
    <div style="margin-left: 30em; padding:5em 0 5em 0">
        <div class="forgotpassword" style="height: 25em">
            <h3>Reset password</h3>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <label>Email:</label>
                <input type="email" name="email" required>

                <label>New Password:</label>
                <input type="password" name="password" required>

                <label>Confirm Password:</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit">Reset Password</button>
            </form>
            <a href="{{ url('/login') }}">Login</a>
        </div>
    </div>
@endsection
