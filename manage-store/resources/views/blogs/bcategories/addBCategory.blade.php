@extends('layouts.home')
@section('content')
    <div class="category">
        <div class="Add">
            <div class="title">
                <p>Create Category Blog</p>
            </div>
            <div class="action">
                <a href="{{ url('bcategories') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action="/bcategories" method="POST">
                @csrf
                <label>Name Category Blog:</label><br>
                <input name="nameBCategory" id="NameBCategory" placeholder="Enter Name Category Blog" required><br>
                <label>Id Category Blog:</label><br>
                <input name="idBCategory" id="BCategorySlug" placeholder="Enter Id Category Blog" required><br>
                <label>Status</label><br>
                <select name="statusBCategory">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select><br>
                <button type="submit">Submit</button>
            </form>
        </div>
        <script>
            document.getElementById('NameBCategory').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('BCategorySlug').value = slug;
            });
        </script>
    </div>
    @include('components.fail')
@endsection