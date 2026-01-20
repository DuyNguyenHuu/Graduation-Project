@extends('layouts.home')
@section('content')
<div class="container">
    <div class="box">
        <h3>Order statistics</h3>
        <div class="stats">
            <a href="{{ url('orders?search=&date=' . now()->toDateString() . '&method=&status=') }}" style="text-decoration: none; color: black;">
                <div class="stat" style="width:150px">
                    <label>Orders Today:</label><br>
                    <span>{{ $countOrderToday }}</span><span style="color: red">{{ number_format($percentChangeOrders, 2) }}%</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=1') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #F4A100; color: white;width:150px">
                    <label>Pending: </label><br>
                    <span>{{ $countPendingOrders }}</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=2') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #007BFF; color: white;width:150px">
                    <label>Processing: </label><br>
                    <span>{{ $countProcessingOrders }}</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=3') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #6F42C1; color: white;width:150px">
                    <label>Shipped: </label><br>
                    <span>{{ $countShippedOrders }}</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=4') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #28A745; color: white;width:150px">
                    <label>Delivered: </label><br>
                    <span>{{ $countDeliveredOrders }}</span><br>
                </div>
            </a>
        </div>
        <a href="{{ url('orders') }}" class="btn btn-link">
            <button>Manage Orders</button>
        </a>
    </div>
    <div class="box">
        <h3>Revenue statistics</h3>
        <div class="stats">
            <div class="stat" style="width:300px">
                <label>Revenue today: </label><br>
                <span>{{ $currentRevenue }}$</span><span style="color: red">{{ number_format($percentChange, 2) }}%</span>
            </div>
            <div class="stat" style="width:300px">
                <label>Revenue this month: </label><br>
                <span>{{ $currentRevenueMonth }}$</span><span style="color: red">{{ number_format($percentChangeMonth, 2) }}%</span>
            </div>
        </div>
        <a href="{{ url('orders') }}" class="btn btn-link">
            <button>Manage Orders</button>
        </a></div>
    <div class="box">
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <script>
        const revenueLabels = @json(collect($finalData)->pluck('date'));
        const revenueData   = @json(collect($finalData)->pluck('revenue'));

        document.addEventListener('DOMContentLoaded', function () {
            renderRevenueChart('revenueChart', revenueLabels, revenueData);
        });
    </script>
    <div class="box">Phần 4</div>
</div>
@endsection