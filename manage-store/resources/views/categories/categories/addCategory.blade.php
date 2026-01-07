@extends('layouts.home')
@section('content')
    <div class="category">
        <div class="Add">
            <div class="title">
                <p>Create Category</p>
            </div>
            <div class="action">
                <a href="{{ url('categories') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action="/categories" method="POST">
                @csrf
                <label>Name Category:</label><br>
                <input name="nameCategory" id="NameCategory" placeholder="Enter Name Category" required><br>
                <label>Id Category:</label><br>
                <input name="idCategory" id="CategorySlug" placeholder="Enter Id Category" required><br>
                <label>Status</label><br>
                <select name="statusCategory">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select><br>
                <button type="submit">Submit</button>
            </form>
        </div>
        <script>
            document.getElementById('NameCategory').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('CategorySlug').value = slug;
            });
        </script>
    </div>
    @include('components.fail')
@endsection