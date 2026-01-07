@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>User</p>
            </div>
            <div class="action">
                <a href="{{ url('users') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action="/users/{{ $getUserById->IdUser }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-left: 12%; margin-right: 12%;">
                    <div>
                        <label>Name:</label><br>
                        <input type="text"name="name" value="{{ $getUserById->Name }}" readonly><br>
                        <label>Status</label><br>
                        <select name="status" value="{{ $getUserById->Status }}">
                            <option value="1" {{ $getUserById->Status == 1 ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $getUserById->Status == 0 ? 'selected' : '' }}>Disabled</option>
                        </select><br>
                        <label>Role</label><br>
                        <select name="role" value="{{ $getUserById->ROLE }}">
                            <option value="1" {{ $getUserById->ROLE == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ $getUserById->ROLE == 0 ? 'selected' : '' }}>User</option>
                        </select><br>
                    </div>
                </div>
                <button type="submit" style="margin-left: 12%">Submit</button>
            </form>
            
        </div>
    </div>
    @include('components.fail')
@endsection