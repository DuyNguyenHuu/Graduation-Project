@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>Order Detail</p>
            </div>
            <div class="" style="background-color: white">
                <form method="POST" action="/orders/{{ $orderId->id }}">
                    @csrf
                    @method('PUT')
                    <label>Status</label><br>
                    <select name="status">
                        <option value="1" {{ $orderId->status == 1 ? 'selected' : '' }}>Pending</option>
                        <option value="2" {{ $orderId->status == 2 ? 'selected' : '' }}>Processing</option>
                        <option value="3" {{ $orderId->status == 3 ? 'selected' : '' }}>Shipped</option>
                        <option value="0" {{ $orderId->status == 0 ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Image Product</th>
                    <th>Name Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                @foreach ($getOrderById as $row)
                <tr>
                    <td><img src="{{ $row->product_image }}" alt="{{ $row->product_name }}" style="width: 50px; height: 50px;"></td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->price }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @include('components.fail')
@endsection