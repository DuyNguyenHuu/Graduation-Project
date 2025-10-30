@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Blog</p>
        </div>
        <div>
            <a href="{{ url('blogs') }}" role="button" style="text-decoration: none">Back</a>
        </div>
    </div>
    <div class="formUpdate">
        <form action="/blogs/{{ $blogShow->IdBlog }}" method="POST">
            @csrf
            @method('PUT')
            <label>Name Blog:</label><br>
            <input name="nameBlog" id="NameBlog" value="{{ $blogShow->Blog }}"><br>
            <label>Id Blog:</label><br>
            <input name="idBlog" id="BlogSlug" value="{{ $blogShow->IdBlog }}"><br>
            <label>Image Blog:</label><br>
            <input name="imageBlog" value="{{ $blogShow->ImageBlog }}"><br>
            <label>Name Category</label><br>
            <select name="categoryBlog">
                @foreach ( $categoryBlogShow as $row)
                    <option value="{{ $row->IdBCategory }}" {{ $row->IdBCategory == $blogShow->CategoryBlog ? 'selected' :''}}>{{ $row->BCategory }}</option>
                @endforeach
            </select>
            <label>Status</label><br>
            <select name="statusBlog" value="{{ $blogShow->StatusBlog }}">
                <option value="1" {{ $blogShow->StatusBlog == 1 ? 'selected' : '' }}>Publish</option>
                <option value="0" {{ $blogShow->StatusBlog == 0 ? 'selected' : '' }}>UnPublish</option>
            </select><br>
            <label>Description Blog:</label><br>
            <textarea name="descriptionBlog" id="editor"">{{ $blogShow->DescriptionBlog }}</textarea>
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
</div>
@endsection