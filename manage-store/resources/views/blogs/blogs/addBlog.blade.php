@extends('layouts.home')
@section('content')
<div class="category">
    <div class="Add">
        <div>
            <p>Create Blog</p>
        </div>
        <div>
            <a href="{{ url('blogs') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/blogs" method="POST">
            @csrf
            <label>Name Blog:</label><br>
            <input name="nameBlog" id="NameBlog" placeholder="Enter Name Blog"><br>
            <label>Id Blog:</label><br>
            <input name="idBlog" id="BlogSlug" placeholder="Enter Id Blog"><br>
            <label>Image Blog:</label><br>
            <input name="imageBlog" placeholder="Enter Image Blog"><br>
            <label>Category Blog:</label>
            <select name="categoryBlog">
                @foreach ($getCategoryBlog as $row)
                    <option value="{{ $row->IdBCategory }}">{{ $row->BCategory }}</option>
                @endforeach
            </select>
            <label>Description Blog:</label><br>
            <textarea name="descriptionBlog" id="editor"></textarea>
            <label>Status</label><br>
            <select name="statusBlog">
                <option value="1">Publish</option>
                <option value="0">UnPublish</option>
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
    
        document.getElementById('NameBlog').addEventListener('input', function() {
            const slug = generateSlug(this.value);
            document.getElementById('BlogSlug').value = slug;
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
</div>
@endsection