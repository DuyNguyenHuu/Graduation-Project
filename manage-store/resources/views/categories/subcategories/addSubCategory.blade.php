@extends('layouts.home')
@section('content')
    <div class="category">
        <div class="Add">
            <div class="title">
                <p>Create Sub Category</p>
            </div>
            <div class="action">
                <a href="{{ url('subcategories') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action='/subcategories' method="POST">
                @csrf
                <label>Select Category</label><br>
                <select name="idCategory">
                    @foreach ($categoryList as $row)
                        <option value={{ $row->IdCategory }}>{{ $row->NameCategory }}</option>
                    @endforeach
                </select><br>
                <label>Sub Name</label><br>
                <input name="nameSubCategory" id="nameSubCategory"placeholder="Enter Name Sub Category" required><br>
                <label>Id Sub</label><br>
                <input name="idSubCategory" id="SubCategorySlug"placeholder="Enter Slug Sub Category" required><br>
                <label>Status</label><br>
                <select name="statusSub">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select><br>
                <button type="submit">Submit</button>
            </form>
        </div>
        <script>
            document.getElementById('nameSubCategory').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('SubCategorySlug').value = slug;
            });
        </script>
    </div>
    @include('components.fail')
@endsection