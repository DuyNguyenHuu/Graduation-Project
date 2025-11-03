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
    </tr>

    @php $total = 0; @endphp

    @foreach($cart as $item)
        @php $total += $item['price'] * $item['quantity']; @endphp
        <tr>
            <td><img src="{{ $item['image'] }}" width="50"></td>
            <td>{{ $item['name'] }}</td>
            <td>{{ number_format($item['price']) }}$</td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['size'] }}</td>
            <td>{{ $item['type'] }}</td>
            <td>{{ number_format($item['price'] * $item['quantity']) }}$</td>
        </tr>
    @endforeach
</table>

<h3>Total: {{ number_format($total) }}$</h3>
