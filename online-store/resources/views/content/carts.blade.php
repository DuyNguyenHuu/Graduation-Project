@extends('layouts.template')

@section('content')
    <div class="carts">
        <h2>Giỏ hàng</h2>
        <table class="table">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Size</th>
                <th>Type</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach($cart as $key=>$item)
                @php
                    $total += $item['price'] * $item['quantity'];
                @endphp
                <tr>
                    <td><img src="{{ $item['image'] }}" width="50" alt="{{ $item['name'] }}"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price']) }}$</td>
                    <td style="width: 20%">
                        <form action="{{ route('cart.decrease', $key) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button style="padding:5px 10px;">-</button>
                        </form>
                        <span style="padding: 0 10px;">{{ $item['quantity'] }}</span>
                        <form action="{{ route('cart.increase', $key) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button style="padding:5px 10px;">+</button>
                        </form>
                    </td>
                    <td>{{ $item['size'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ number_format($item['price'] * $item['quantity'], 2, '.', ',') }}$</td>
                    <td>
                        <form action="{{ route('cart.remove', $key) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="border:none;background:none;color:red;font-size:22px;cursor:pointer;">
                                ×
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <?php
                session()->put('total',$total,);
            ?>
        </table>
    </div>
    <div class="cart-summary">
        <div class="cart-summary-row">
            <div>
                <form action="{{ route('cart.applyCoupon') }}" method="POST">
                    @csrf
                    <input type="text" name="coupon_code" placeholder="Coupon code">
                    <input type="hidden" name="total" value="{{ $total }}">
                    <button type="submit">Apply Coupon</button>
                </form>
                @if(session('coupon_error'))
                    <p style="color:red">{{ session('coupon_error') }}</p>
                @endif

                @if(session('coupon_success'))
                    <p style="color:green">{{ session('coupon_success') }}</p>
                @endif
            </div>
            <div>
                @if(session('cart') != null)
                    <h3>Total: {{ number_format($total, 2, '.', ',');}}$</h3>
                    @if(session('coupon'))
                        <h3>Discount: -{{ number_format(session('coupon.discount', 2, '.', ',')) }}$</h3>
                        <h3>Final Total: {{ number_format(session('coupon.final_total', 2, '.', ',')) }}$</h3>
                    @endif
                @elseif(session('cart')==null)
                    <?php session()->forget('coupon')?>
                @endif
            </div>
        </div>
        <div class="cart-summary-buttons">
            <a href="{{ route('products') }}">
                <button>
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Shopping
                </button>
            </a>
            @if(session()->has('cart') && count(session('cart')) > 0)
                <a href="{{ route('checkout.form') }}">
                    <button>Checkout</button>
                </a>
            @endif
        </div>
    </div>

@endsection
