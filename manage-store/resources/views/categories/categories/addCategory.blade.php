@extends('layouts.home')
@section('content')
<div class="category">
    <div class="Add">
        <div>
            <p>Create Category</p>
        </div>
        <div>
            <a href="{{ url('categories') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/categories" method="POST">
            @csrf
            <label>Name Category:</label><br>
            <input name="nameCategory" id="NameCategory" placeholder="Enter Name Category"><br>
            <label>Id Category:</label><br>
            <input name="idCategory" id="CategorySlug" placeholder="Enter Id Category"><br>
            <label>Status</label><br>
            <select name="statusCategory">
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
    
        document.getElementById('NameCategory').addEventListener('input', function() {
            const slug = generateSlug(this.value);
            document.getElementById('CategorySlug').value = slug;
        });
    </script>
</div>
@endsection