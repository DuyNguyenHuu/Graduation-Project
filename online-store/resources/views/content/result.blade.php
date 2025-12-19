@extends('layouts.template')

@section('content')
    @if (session('message') == 'Payment successful!')
        <div class="result">
            <div>
                <h2 style="color: green; text-align: center;">{{ session('message') }}</h2>
            </div>
            <div style="display: flex;justify-content: space-around">
                <a href="/orders"><button>Your Order</button></a>
                <a href="/"><button>Home</button></a>
            </div>
        </div>
    @else
        <div class="result">
            <h2 style="color: red; text-align: center;">{{ session('message') }}</h2>
            <div style="display: flex;justify-content: space-around">
                <a href="/orders"><button>Your Order</button></a>
                <a href="/"><button>Home</button></a>
            </div>
        </div>
    @endif
@endsection
