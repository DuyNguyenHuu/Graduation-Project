@extends('layouts.home')
@section('content')
    <div class="category">
        <div class="Add">
            <div class="title">
                <p>Create Category</p>
            </div>
            <div class="action">
                <a href="{{ route('productList.attribute',['productList' => $productList]) }}">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form method="POST" action="{{ route('productList.storeAttribute',['productList' => $productList]) }}">
                @csrf
                <label>Option Product:</label>
                <select name="optionProduct">
                    <option value="SIZE">SIZE</option>
                    <option value="TYPE">TYPE</option>
                </select>
                <label>Sub Option:</label><br>
                <input name="subOptionProduct" placeholder="Enter Option" required><br>
                <label>Quantity:</label><br>
                <input name="quantityProduct" type="number" min=0 value="{{ old('quantityProduct', 0) }}"placeholder="Enter Quantity" required><br>
                <label>Bonus Price:</label><br>
                <input name="priceProduct" type="number" step=0.01 placeholder="Enter Price" required><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    @include('components.fail')
@endsection