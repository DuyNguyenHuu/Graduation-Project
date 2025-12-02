@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div class="title">
            <p>Coupon</p>
        </div>
        <div class="action">
            <a href="{{ url('coupons') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/coupons/{{ $getCoupon->IdCoupon }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display:flex; justify-content: space-around;">
                <div>
                    <label>Title:</label><br>
                    <input type="text"name="title" value="{{ $getCoupon->Title }}" required><br>
                    <label>Code:</label><br>
                    <input type="text"name="code" value="{{ $getCoupon->Code }}" required><br>
                    <label>Condition:</label><br>
                    <input type="number" step="0.01" name="condition" value="{{ $getCoupon->ConditionCoupon }}" required><br>
                    <label>No. Of Time</label>
                    <input type="number" min="1" name="time" value="{{ $getCoupon->Time }}">
                    <label>Status</label><br>
                    <select name="status" value="{{ $getCoupon->StatusCoupon }}">
                        <option value="1" {{ $getCoupon->StatusCoupon == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ $getCoupon->StatusCoupon == 0 ? 'selected' : '' }}>Disabled</option>
                    </select><br>
                </div>
                <div>
                    <label>Discount Type:</label>
                    <select name="discounttype" value="{{ $getCoupon->DiscountType }}">
                        <option value="1" {{ $getCoupon->DiscountType == 1 ? 'selected' : '' }}>%</option>
                        <option value="2" {{ $getCoupon->DiscountType == 2 ? 'selected' : '' }}>$</option>
                    </select>
                    <label>Discount Value</label><br>
                    <input type="number" step="0.01" name="discountvalue" value="{{ $getCoupon->DiscountValue }}" required><br>
                    <label>Start Date</label><br>
                    <input type="date" name="startdate" value="{{ $getCoupon->StartDate }}"><br>
                    <label>End Date</label><br>
                    <input type="date" name="enddate" value="{{ $getCoupon->EndDate }}"><br>
                </div>
            </div>
            <button type="submit" style="margin-left: 12%">Submit</button>
        </form>
        
    </div>
</div>
@endsection