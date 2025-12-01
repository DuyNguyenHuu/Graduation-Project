@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Coupon</p>
            </div>
            <div>
                <a href="coupons/create" role="button" style="text-decoration: none">Add</a>
            </div>
        </div>
        <div>
            <form method="GET" action="{{ url('/coupons') }}" >
                <div class="filter">
                    <div>
                        <label>Search</label><br>
                        <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search Title or Code">
                    </div>
                    <div>
                        <label></label>Discount Type</label><br>
                        <select name="discount_type">
                            <option value="">All Types</option>
                            <option value="1" {{ request('discount_type') == 1 ? 'selected' : '' }}>%</option>
                            <option value="2" {{ request('discount_type') == 2 ? 'selected' : '' }}>$</option>
                        </select>
                    </div>
                    <div>
                        <label>Start Date</label><br>
                        <input type="date"
                        name="start_date"
                        value="{{ request('start_date') }}">
                    </div>
                    <div>
                        <label>End Date</label><br>
                        <input type="date"
                        name="end_date"
                        value="{{ request('end_date') }}">
                    </div>
                    <div>
                        <label>Status</label><br>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Enabled</option>
                            <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <button type="submit">Filter</button>
                </div>
            </form>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Discount Type</th>
                    <th>Discount Value</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>No. Of Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($getCoupon as $row)
                <tr>
                    <td>{{ Str::limit($row->Title, 20, '...') }}</td>
                    <td>{{ $row->Code }}</td>
                    @if ($row->DiscountType == 1)
                        <td>%</td>
                    @elseif ($row->DiscountType == 2)
                        <td>$</td>
                    @endif
                    <td>{{ $row->DiscountValue }}</td>
                    <td>{{ $row->StartDate }}</td>
                    <td>{{ $row->EndDate }}</td>
                    <td>{{ $row->Time }}</td>
                    @if ($row->StatusCoupon == 1)
                        <td style="color:green">Enabled</td>
                    @else
                        <td style="color:red">Disabled</td>
                    @endif
                    <td>
                        <div style="display:flex;justify-content:space-evenly">
                            <div><a href="coupons/{{ $row->IdCoupon }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                            <div>
                                <form action="/coupons/{{ $row->IdCoupon }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getCoupon->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div id="toastsuccess">
            {{ session('success') }}
        </div>

        <script>
            const toast = document.getElementById('toastsuccess');
            setTimeout(() => { toast.style.opacity = 1; }, 100);
            setTimeout(() => { toast.style.opacity = 0; }, 3000);
        </script>
    @endif

@endsection