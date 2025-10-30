@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Update Category Blog</p>
        </div>
        <div>
            <a href="{{ url('bcategories') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/bcategories/{{ $bCategoryShow->IdBCategory }}" method="POST">
            @csrf
            @method('PUT')
            <label>Name Category Blog:</label><br>
            <input name="nameBCategory" id="NameBCategory" value="{{ $bCategoryShow->BCategory }}"><br>
            <label>Id Category Blog:</label><br>
            <input name="idBCategory" id="BCategorySlug" value="{{ $bCategoryShow->IdBCategory }}"><br>
            <label>Status</label><br>
            <select name="statusBCategory" value="{{ $bCategoryShow->StatusBCategory }}">
                <option value="1" {{ $bCategoryShow->StatusBCategory == 1 ? 'selected' : '' }}>Enabled</option>
                <option value="0" {{ $bCategoryShow->StatusBCategory == 0 ? 'selected' : '' }}>Disabled</option>
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
        
            document.getElementById('NameBCategory').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('BCategorySlug').value = slug;
            });
        </script>
    </div>
</div>
@endsection