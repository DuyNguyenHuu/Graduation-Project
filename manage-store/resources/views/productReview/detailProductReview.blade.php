@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Detail Review Product</p>
        </div>
        <div>
            <a href="{{ url('productReview') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        @foreach ($detailProductReview as $row)
            <form method="POST" action=" /productReview/{{ $row->IdReview }}">
                @csrf
                @method("PUT")
                <label>Name:</label><br>
                <input name="nameProductReview" value="{{ $row->Name }}" readonly><br>
                <label>Email:</label><br>
                <input name="emailProductReview" value="{{ $row->email }}" readonly><br>
                <label>Name:</label><br>
                <input name="phoneProductReview" value="{{ $row->Phone }}" readonly><br>
                <label>Rating:</label><br>
                <input name="nameProductReview" value="{{ $row->Evaluate }}" readonly><br>
                <label>Review:</label><br>
                <input name="reviewProductReview" value="{{ $row->Comments }}" readonly><br>
                <label>Status: </label>
                <select name="statusProductReview">
                    <option value=1 {{ $row->Status == 1 ? 'selected' : '' }}>Enabled</option>
                    <option value=0 {{ $row->Status == 0 ? 'selected' : '' }}>Disabled</option>
                </select><br>
                <button type="submit">Submit</button>
            </form>
        @endforeach
    </div>
</div>
@endsection