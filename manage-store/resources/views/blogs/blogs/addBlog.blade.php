@extends('layouts.home')
@section('content')
    <div class="category">
        <div class="Add">
            <div class="title">
                <p>Create Blog</p>
            </div>
            <div class="action">
                <a href="{{ url('blogs') }}" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="formUpdate">
            <form action="/blogs" method="POST">
                @csrf
                <label>Name Blog:</label><br>
                <input name="nameBlog" id="NameBlog" placeholder="Enter Name Blog" required><br>
                <label>Id Blog:</label><br>
                <input name="idBlog" id="BlogSlug" placeholder="Enter Id Blog" required><br>
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
            document.getElementById('NameBlog').addEventListener('input', function() {
                const slug = generateSlug(this.value);
                document.getElementById('BlogSlug').value = slug;
            });
        </script>
        <script>
            CKEDITOR.replace('editor');
        </script>
    </div>
    @include('components.fail')
@endsection