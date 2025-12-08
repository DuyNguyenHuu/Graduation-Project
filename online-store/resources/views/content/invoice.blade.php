@extends('layouts.template')

@section('content')
    <div class="invoice">
        <h3>Review Your Order</h3>
        <div class="invoice_info">
            <h3>Review Your Delivery Information</h3>
            <span>Name: </span>{{ session('delivery_info')['fullname'] }}<br>
            <span>Phone: </span>{{ session('delivery_info')['phone'] }}<br>
            <span>Province/City: </span>{{ session('delivery_info')['province_name'] }}<br>
            <span>Commune/Ward: </span>{{ session('delivery_info')['ward_name'] }}<br>
            <span>Address: </span>{{ session('delivery_info')['address'] }}<br>
            <span>Note: </span>{{ session('delivery_info')['note'] }}<br>
        </div>
        <div class="invoice_order">
            <div class="invoice_product">
                <h3>Items In Your Order</h3>
                @foreach(session('cart') as $key =>$item)
                    <a href="/products/{{ $item['id'] }}">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                        <p>{{ $item['name'] }}</p>
                    </a>
                    <span>{{ $item['quantity'] }} x {{ $item['price'] }}$</span>
                @endforeach
            </div>
            <div class="invoice_total">
                <h3>Order Summary</h3>
                @if(session('coupon') != null)
                    <span>Total: </span>{{ session('total') }}$<br>
                    <span>Discount: </span>{{ session('coupon')['discount'] }}$<br>
                    <span>Final Total: </span>{{ session('coupon')['final_total'] }}$
                @else
                    <span>Total: </span>{{ session('total') }}$<br>
                @endif
            </div>
        </div>
        <a href="/payment/create">
            <button>Payment</button>
        </a>
    </div>

@endsection
