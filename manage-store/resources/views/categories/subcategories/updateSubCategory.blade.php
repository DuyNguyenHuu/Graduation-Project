@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Update Sub Category</p>
        </div>
        <div>
            <a href="{{ url('subcategories') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/subcategories/{{ $subCategoryShow->IdSub }}" method="POST">
            @csrf
            @method('PUT')
            <label>Name Category</label><br>
            <select name="nameCategory">
                @foreach ( $categoryList as $row)
                    <option value="{{ $row->IdCategory }}" {{ $row->IdCategory == $subCategoryShow->IdCategory ? 'selected' :''}}>{{ $row->NameCategory }}</option>
                @endforeach
            </select>
            <input type="" name="hiddenCategory" value="{{ $subCategoryShow->IdCategory }}">
            <label>Name</label><br>
            <input name="nameSubCategory" id="nameSubCategory"value="{{ $subCategoryShow->Name }}"><br>
            <label>Id Sub</label><br>
            <input name="idSubCategory" id="SubCategorySlug"value="{{ $subCategoryShow->IdSub }}"><br>
            <label>Status</label>
            <select name="statusSubCategory">
                <option value="1" {{ $subCategoryShow->StatusSub == 1 ? 'selected' : '' }}>Enabled</option>
                <option value="0" {{ $subCategoryShow->StatusSub == 0 ? 'selected' : '' }}>Disabled</option>
            </select><br>
            <button type="submit">Submit</button>
        </form>
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
</div>
@endsection