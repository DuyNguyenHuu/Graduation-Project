    <h2>Hello {{ $order->Name }}</h2>

    <p>Your order <strong>#{{ $order->id }}</strong> has been updated.</p>

    <p>
        <strong>Current status:</strong>
        @if($order->status == 1)
            <span style="color:#F4A100">Pending</span>
        @elseif($order->status == 2)
            <span style="color:#007BFF">Processing</span>
        @elseif($order->status == 3)
            <span style="color:#6F42C1">Shipped</span>
        @elseif($order->status == 4)
            <span style="color:#17A2B8">Delivered</span>
        @endif
    </p>

    <p>Thank you for shopping with us!</p>