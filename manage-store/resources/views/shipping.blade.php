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
            <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('editor');
            </script>
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
    </div>
@endsection