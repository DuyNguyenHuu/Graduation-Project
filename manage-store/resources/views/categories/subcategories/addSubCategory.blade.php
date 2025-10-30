@extends('layouts.home')
@section('content')
<div class="category">
    <div class="Add">
        <div>
            <p>Create Sub Category</p>
        </div>
        <div>
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
            <input name="nameSubCategory" id="nameSubCategory"placeholder="Enter Name Sub Category"><br>
            <label>Id Sub</label><br>
            <input name="idSubCategory" id="SubCategorySlug"placeholder="Enter Slug Sub Category"><br>
            <label>Status</label><br>
            <select name="statusSub">
                <option value="1">Enabled</option>
                <option value="0">Disabled</option>
            </select><br>
            <button type="submit">Submit</button>
        </form>
    </div>
    <script>
        function generateSlug(str) {
            return str
                .toLowerCase()
                .normalize('NFD')                         // tách dấu tiếng Việt
                .replace(/[\u0300-\u036f]/g, '')          // xóa dấu
                .replace(/[^a-z0-9\s-]/g, '')             // bỏ ký tự đặc biệt
                .trim()
                .replace(/\s+/g, '-')                     // thay khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-');                     // gộp nhiều dấu - liền nhau
        }
    
        document.getElementById('nameSubCategory').addEventListener('input', function() {
            const slug = generateSlug(this.value);
            document.getElementById('SubCategorySlug').value = slug;
        });
    </script>
</div>
@endsection