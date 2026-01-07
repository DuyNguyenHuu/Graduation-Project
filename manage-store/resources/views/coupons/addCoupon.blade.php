@extends('layouts.home')
@section('content')
    <div class="category">
        <div class="Add">
            <div class="title">
                <p>Create Coupon</p>
            </div>
            <div class="action">
                <a href="{{ url('coupons') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action="/coupons" method="POST">
                @csrf
                <div style="display:flex; justify-content: space-around;">
                    <div>
                        <label>Title:</label><br>
                        <input type="text"name="title" placeholder="Enter Title" required><br>
                        <label>Code:</label><br>
                        <input type="text"name="code" placeholder="Enter Code" required><br>
                        <label>Condition:</label><br>
                        <input type="number" step="0.01" name="condition" placeholder="Enter Condition" required><br>
                        <label>No. Of Time</label>
                        <input type="number" min="1" name="time">
                        <label>Status</label><br>
                        <select name="status">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select><br>
                    </div>
                    <div>
                        <label>Discount Type:</label>
                        <select name="discounttype">
                            <option value="1">%</option>
                            <option value="2">$</option>
                        </select>
                        <label>Discount Value</label><br>
                        <input type="number" step="0.01" name="discountvalue" placeholder="Enter Discount Value" required><br>
                        <label>Start Date</label><br>
                        <input type="date" name="startdate"><br>
                        <label>End Date</label><br>
                        <input type="date" name="enddate"><br>
                    </div>
                </div>
                <button type="submit" style="margin-left: 12%">Submit</button>
            </form>
        </div>
    </div>
    @include('components.fail')
@endsection