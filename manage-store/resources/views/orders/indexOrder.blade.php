@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>Order</p>
            </div>
            <div class="action" style="background-color: white">
            </div>
        </div>
        <div>
            <form method="GET" action="{{ url('/orders') }}" >
                <div class="filter">
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
                        <label>Payment Method</label><br>
                        <select name="method">
                            <option value="">All Method</option>
                            <option value="cod" {{ request('method') === "cod" ? 'selected' : '' }}>COD</option>
                            <option value="vnpay" {{ request('method') === "vnpay" ? 'selected' : '' }}>VNPAY</option>
                        </select>
                    </div>
                    <div>
                        <label>Status</label><br>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === "1" ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('status') === "2" ? 'selected' : '' }}>Processing</option>
                            <option value="3" {{ request('status') === "3" ? 'selected' : '' }}>Shipped</option>
                            <option value="4" {{ request('status') === "4" ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                    <button type="submit">Filter</button>
                </div>
            </form>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Order Id</th>
                    <th>User</th>
                    <th>Consignee</th>
                    <th>Phone</th>
                    <th>Province</th>
                    <th>Ward</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                @foreach ($getOrder as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->consignee }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->province }}</td>
                    <td>{{ $row->ward }}</td>
                    <td>{{ $row->address }}</td>
                    <td>{{ $row->method }}</td>
                    <td>{{ $row->total }}$</td>
                    <td>{{ $row->created_at }}</td>
                    @if ($row->status == 1)
                        <td style="color:#F4A100">Pending</td>
                    @elseif ($row->status == 2)
                        <td style="color:#007BFF">Processing</td>
                    @elseif ($row->status == 3)
                        <td style="color:#6F42C1">Shipped</td>
                    @elseif ($row->status == 4)
                        <td style="color:#28A745">Delivered</td>
                    @endif
                    <td>
                        <div style="display:flex;justify-content:space-evenly">
                            <div><a href="orders/{{ $row->id }}/edit"><i class="fa-solid fa-eye"></i></a></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getOrder->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @include('components.success')
@endsection