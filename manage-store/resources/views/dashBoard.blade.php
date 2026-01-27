@extends('layouts.home')
@section('content')
<div class="container">
    <div class="box">
        <h3>Order statistics</h3>
        <div class="stats">
            <a href="{{ url('orders?search=&date=' . now()->toDateString() . '&method=&status=') }}" style="text-decoration: none; color: black;">
                <div class="stat">
                    <label>Orders Today:</label><br>
                    <span>{{ $countOrderToday }}</span><span style="color: red">{{ number_format($percentChangeOrders, 2) }}%</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=1') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #F4A100; color: white;">
                    <label>Pending: </label><br>
                    <span>{{ $countPendingOrders }}</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=2') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #007BFF; color: white;">
                    <label>Processing: </label><br>
                    <span>{{ $countProcessingOrders }}</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=3') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #6F42C1; color: white;">
                    <label>Shipped: </label><br>
                    <span>{{ $countShippedOrders }}</span><br>
                </div>
            </a>
            <a href="{{ url('orders?search=&date=&method=&status=4') }}" style="text-decoration: none">
                <div class="stat" style="background-color: #28A745; color: white;">
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
            <div class="stat">
                <label>Revenue today: </label><br>
                <span>{{ $currentRevenue }}$</span><span style="color: red">{{ number_format($percentChange, 2) }}%</span>
            </div>
            <div class="stat">
                <label>Revenue this month: </label><br>
                <span>{{ $currentRevenueMonth }}$</span><span style="color: red">{{ number_format($percentChangeMonth, 2) }}%</span>
            </div>
        </div>
        <a href="{{ url('orders') }}" class="btn btn-link">
            <button>Manage Orders</button>
        </a></div>
    <div class="box">
        <h3>Sales chart</h3>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <script>
        const revenueLabels = @json(collect($finalData)->pluck('date'));
        const revenueData   = @json(collect($finalData)->pluck('revenue'));

        document.addEventListener('DOMContentLoaded', function () {
            renderRevenueChart('revenueChart', revenueLabels, revenueData);
        });
    </script>
    <div class="box">
        <h3>General information</h3>
        <div class="stats">
            <a href="{{ url('users') }}" style="text-decoration: none">
                <div class="stat">
                    <label>Total Users: </label><br>
                    <span>{{ $countUsers }}</span><br>
                </div>
            </a>
            <a href="{{ url('productList') }}">
                <div class="stat" style="text-decoration: none">
                    <label>Total Products: </label><br>
                    <span>{{ $countProducts }}</span><br>
                </div>
            </a>
            <a href="{{ url('users?search=&role=&status=&from_date=' . now()->toDateString() . '&to_date=') }}" style="text-decoration: none">
                <div class="stat">
                    <label>Users Today:</label><br>
                    <span>{{ $countUsersToday }}</span><span style="color: red">{{ number_format($percentChangeUsers, 2) }}%</span><br>
                </div>
            </a>
    </div>
</div>
@endsection