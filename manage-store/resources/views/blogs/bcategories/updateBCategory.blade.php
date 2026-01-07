@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>Update Category Blog</p>
            </div>
            <div class="action">
                <a href="{{ url('bcategories') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action="/bcategories/{{ $bCategoryShow->IdBCategory }}" method="POST">
                @csrf
                @method('PUT')
                <label>Name Category Blog:</label><br>
                <input name="nameBCategory" id="NameBCategory" value="{{ $bCategoryShow->BCategory }}" required><br>
                <label>Id Category Blog:</label><br>
                <input name="idBCategory" id="BCategorySlug" value="{{ $bCategoryShow->IdBCategory }}" required><br>
                <label>Status</label><br>
                <select name="statusBCategory" value="{{ $bCategoryShow->StatusBCategory }}">
                    <option value="1" {{ $bCategoryShow->StatusBCategory == 1 ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ $bCategoryShow->StatusBCategory == 0 ? 'selected' : '' }}>Disabled</option>
                </select><br>
                <button type="submit">Submit</button>
            </form>
            <script>
                document.getElementById('NameBCategory').addEventListener('input', function() {
                    const slug = generateSlug(this.value);
                    document.getElementById('BCategorySlug').value = slug;
                });
            </script>
        </div>
    </div>
    @include('components.success')
@endsection