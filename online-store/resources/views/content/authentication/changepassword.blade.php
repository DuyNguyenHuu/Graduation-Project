@extends('layouts.template')

@section('content')
    <div class="deliInfo">
        <h2>Change Password</h2>
        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form action="{{ route('password.change.process') }}" method="POST">
            @csrf
            <label>Old Password:</label><br>
            <input type="password" name="old_password" required><br>
            <label>New Password:</label><br>
            <input type="password" name="new_password" required><br>
            <label>Confirm New Password:</label><br>
            <input type="password" name="new_password_confirmation" required><br>
            <button type="submit">Continue</button>
        </form>
    </div>
@endsection
