@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>Shipping Info</p>
            </div>
            <div>
            </div>
        </div>
        <div class="Table">
            <form method="POST" action="/shippings/1">
                @csrf
                @method('PUT')
                <label>Shipping Info:</label><br>
                <textarea name="shippingInfo" id="editor">{!! $getShipping->Detail !!}</textarea>
                <button type="submit">Submit</button>
            </form>
            <script>
                CKEDITOR.replace('editor');
            </script>
        </div>
    </div>
    @include('components.success')
    @include('components.fail')
@endsection