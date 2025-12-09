@extends('layouts.template')
@section('content')
    <div class="order">
        <h2>Order List</h2>
        <div class="filterOrder">
            <form method="GET" action="{{ url('/orders') }}" >
                <div class="filter" style="display: flex; justify-content: space-around;">
                    <div>
                        <label>Search</label><br>
                        <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search">
                    </div>
                    <div>
                        <label>Date</label><br>
                        <input type="date"
                        name="date"
                        value="{{ request('date') }}">
                    </div>
                    <div>
                        <label>Status</label><br>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === "1" ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('status') === "2" ? 'selected' : '' }}>Processing</option>
                            <option value="3" {{ request('status') === "3" ? 'selected' : '' }}>Shipped</option>
                            <option value="0" {{ request('status') === "0" ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                    <button type="submit">Filter</button>
                </div>
            </form>
        </div>
        <div class="orderList">
            @foreach($getOrders as $row)
                <div onclick="window.location='/orders/{{ $row->id }}'" style="display: flex; justify-content: space-around;">
                    <div>
                        <p><strong>Order ID:</strong> {{ $row->id }}</p>
                        <p><strong>Name:</strong> {{ $row->name }}</p>
                        <p><strong>Date:</strong> {{ $row->created_at }}</p>
                        @if ($row->status==1)
                            <p><strong>Status:</strong> <span style="color:#F4A100">Pending</span></p>
                        @elseif ($row->status==2)
                            <p><strong>Status:</strong> <span style="color:#007BFF">Processing</span></p>
                        @elseif ($row->status==3)
                            <p><strong>Status:</strong> <span style="color:#6F42C1">Shipped</span></p>
                        @elseif ($row->status==0)
                            <p><strong>Status:</strong> <span style="color:#28A745">Delivered</span></p>
                        @endif
                        <p><strong>Total Amount:</strong> ${{ number_format($row->total, 2) }}</p>
                    </div>
                    <div>
                        <p><strong>Consignee:</strong> {{ $row->consignee }}</p>
                        <p><strong>Province:</strong> {{ $row->province }}</p>
                        <p><strong>Ward:</strong> {{ $row->ward }}</p>
                        <p><strong>Address:</strong> {{ $row->address }}</p>
                        <p><strong>Note:</strong> {{ $row->note }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getOrders->links('pagination::bootstrap-5') }}
                </div>
            </div>
    </div>
@endsection