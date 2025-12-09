@extends('layouts.template')
@section('content')
    <div class="order">
        <h2>Order detail number {{ $detailOrder->first()->order_id ?? '' }}</h2>
        <div class="orderList">
            @foreach($detailOrder as $row)
                <div onclick="window.location='/products/{{ $row->product_id }}'" style="display: flex; justify-content: space-around;">
                    <div style="width:100px">
                        <img src="{{ $row->product_image }}" alt="{{ $row->product_name }}" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                    </div>
                    <div style="width:600px">
                        <p><strong>Name Product:</strong> {{ $row->product_name }}</p>
                    </div>
                    <div style="width:400px">
                        <p><strong>Quantity:</strong> {{ $row->quantity }}</p>
                    </div>
                    <div style="width:200px">
                        <p><strong>Price:</strong> {{ $row->price }}$</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection