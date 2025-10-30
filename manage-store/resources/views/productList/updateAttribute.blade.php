@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Update Option</p>
        </div>
        <div>
            <a href="/productList/{{$productList}}/attributes" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form method="POST" action="{{ route('productList.updateAttribute',['productList'=>$productList, $optionEdit->IdOption]) }}">
            @method("PUT")
            @csrf
            <label>Option Product:</label>
            <select name="optionProduct">
                <option value="SIZE" {{ $optionEdit->OptionProduct =="SIZE"? "selected" : "" }}>SIZE</option>
                <option value="TYPE" {{ $optionEdit->OptionProduct =="TYPE"? "selected" : "" }}>TYPE</option>
            </select>
            <label>Sub Option:</label><br>
            <input name="subOptionProduct" value="{{ $optionEdit->SubOption }}"><br>
            <label>Quantity:</label><br>
            <input name="quantityProduct" type="number" min=0 value="{{ $optionEdit->Quantity }}"><br>
            <label>Bonus Price:</label><br>
            <input name="priceProduct" type="number" step=0.01 value="{{ $optionEdit->BonusPrice }}"><br>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
@endsection