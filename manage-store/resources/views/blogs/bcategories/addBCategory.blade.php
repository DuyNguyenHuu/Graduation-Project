@extends('layouts.home')
@section('content')
<div class="category">
    <div class="Add">
        <div>
            <p>Create Category Blog</p>
        </div>
        <div>
            <a href="{{ url('bcategories') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/bcategories" method="POST">
            @csrf
            <label>Name Category Blog:</label><br>
            <input name="nameBCategory" id="NameBCategory" placeholder="Enter Name Category Blog"><br>
            <label>Id Category Blog:</label><br>
            <input name="idBCategory" id="BCategorySlug" placeholder="Enter Id Category Blog"><br>
            <label>Status</label><br>
            <select name="statusBCategory">
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
    
        document.getElementById('NameBCategory').addEventListener('input', function() {
            const slug = generateSlug(this.value);
            document.getElementById('BCategorySlug').value = slug;
        });
    </script>
</div>
@endsection