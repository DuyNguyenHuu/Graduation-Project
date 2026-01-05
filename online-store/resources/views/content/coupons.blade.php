@extends('layouts.template')
@section('content')
    <div class="chooseCoupon">
        <div class="menuCoupon">
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
                    <button type="submit">Filter</button>
                </div>
            </form>
        </div>
        <div style="width:90%">
            <div class="listCoupon">
                @foreach ($getCoupon as $coupon)
                    <div>
                        @include('components.coupon_box', ['coupon' => $coupon])
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getCoupon->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection