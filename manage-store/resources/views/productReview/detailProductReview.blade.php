@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>Detail Review Product</p>
            </div>
            <div class="action">
                <a href="{{ url('productReviews') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
                <form method="POST" action=" /productReviews/{{ $detailProductReview->IdReview }}">
                    @csrf
                    @method("PUT")
                    <label>Name:</label><br>
                    <input name="nameProductReview" value="{{ $detailProductReview->Name }}" readonly><br>
                    <label>Email:</label><br>
                    <input name="emailProductReview" value="{{ $detailProductReview->email }}" readonly><br>
                    <label>Name:</label><br>
                    <input name="phoneProductReview" value="{{ $detailProductReview->Phone }}" readonly><br>
                    <label>Rating:</label><br>
                    <input name="nameProductReview" value="{{ $detailProductReview->Evaluate }}" readonly><br>
                    <label>Review:</label><br>
                    <input name="reviewProductReview" value="{{ $detailProductReview->Comments }}" readonly><br>
                    <label>Status: </label>
                    <select name="statusProductReview">
                        <option value=1 {{ $detailProductReview->Status == 1 ? 'selected' : '' }}>Enabled</option>
                        <option value=0 {{ $detailProductReview->Status == 0 ? 'selected' : '' }}>Disabled</option>
                    </select><br>
                    <button type="submit">Submit</button>
                </form>
        </div>
    </div>
    @include('components.fail')
@endsection