@extends('layouts.template')
@section('content')
    @if (session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="error-message" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div style="display:flex;justify-content:center;gap:3em;padding: 5em 0 5em 0">
        <div class="login">
            <h3>Sign in</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" class="account" name="loginEmail" placeholder="Email"><br>
                <input type="password" class="account" name="loginPassword" placeholder="Password">
                <div style="display:flex; justify-content: space-around;">
                    <div><input type="checkbox">Remember Password</div>
                    <div><a href="{{ route('password.request') }}">Forgot Password</a></div>
                </div>
                <button type="submit">Sign in</button>
            </form>
        </div>
        <div class="register">
            <h3>Sign up</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <input type="text" class="account" name="registerName" placeholder="Enter Name" value="{{ old('registerName') }}">
                </div>
                <div style="display:flex;gap:2.5em;">
                    <div>
                        <input type="email" class="account" name="registerEmail" placeholder="Email" value="{{ old('registerEmail') }}">
                    </div>
                    <div>
                        <input type="text" class="account" name="registerPhone"placeholder="Enter Phone" value="{{ old('registerPhone') }}">
                    </div>
                </div>
                <div style="display:flex;gap:2.5em;">
                    <div>
                        <input type="password" class="account" name="registerPassword" placeholder="Enter Password">
                    </div>
                    <div>
                        <input type="password" class="account" name="registerPassword_confirmation" placeholder="Confirm Password">
                    </div>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function () {
                    successMessage.style.display = 'none';
                }, 55000);
            }

            let errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>
@endsection