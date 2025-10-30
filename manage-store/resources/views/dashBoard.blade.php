@extends('layouts.home')
@section('content')
<div class="background">
    @if (Auth::check())
        <p>Chào mừng, {{ Auth::user()->Name }}</p>
        <p>Email: {{ Auth::user()->email }}</p>
    @endif
</div>
@endsection