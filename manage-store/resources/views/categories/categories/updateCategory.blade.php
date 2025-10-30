@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Update Category</p>
        </div>
        <div>
            <a href="{{ url('categories') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/categories/{{ $categoryShow->IdCategory }}" method="POST">
            @csrf
            @method('PUT')
            <label>Name Category:</label><br>
            <input name="nameCategory" id="NameCategory" value="{{ $categoryShow->NameCategory }}"><br>
            <label>Id Category:</label><br>
            <input name="idCategory" id="CategorySlug" value="{{ $categoryShow->IdCategory }}"><br>
            <label>Status</label><br>
            <select name="statusCategory" value="{{ $categoryShow->Status }}">
                <option value="1" {{ $categoryShow->Status == 1 ? 'selected' : '' }}>Enabled</option>
                <option value="0" {{ $categoryShow->Status == 0 ? 'selected' : '' }}>Disabled</option>
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
        
            document.getElementById('NameCategory').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('CategorySlug').value = slug;
            });
        </script>
    </div>
</div>
@endsection