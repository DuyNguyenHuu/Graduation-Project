@extends('layouts.template')
@section('content')
    <div style="margin-left: 30em; padding:5em 0 5em 0">
        <div class="forgotpassword">
            <h3>Forgot password</h3>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label>Enter your email address</label><br>
                <input type="email" name="email" required placeholder="Enter your email address"><br>
                <label>Type in the email address you used when you registered with our website</label><br>
                <button type="submit">Get new password</button>
            </form>
            <a href="{{ url('/login') }}">Login</a>
             @if (session('status'))
                <p style="color: green;">{{ session('status') }}</p>
            @endif
        </div>
    </div>
@endsection