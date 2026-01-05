@extends('layouts.template')

@section('content')
    <div class="result">
        <div>
            <h2 style="color: green; text-align: center;">{{ $message }}</h2>
        </div>
        <div style="display: flex;justify-content: space-around">
            <a href="/orders"><button>Your Order</button></a>
            <a href="/"><button>Home</button></a>
        </div>
    </div>
@endsection
