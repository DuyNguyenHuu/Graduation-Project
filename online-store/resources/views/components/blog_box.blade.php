<a href="/blogs/{{ $blog->IdBlog }}" style="text-decoration: none;">
    <div class="blogTemplate">
        <div class="blogImage">
            <img src="{{ asset($blog->ImageBlog) }}" alt="{{ $blog->ImageBlog }}" width="100%">
        </div>
        <div class="blogName">
            <p>{{ $blog->Blog }}</p>
        </div>
        <div class="blogDate">
            <p>{{ $blog->updated_at }}</p>
        </div>
        <hr>
        <div class="blogDescription">
            @php
                use Illuminate\Support\Str;
                // Lấy đoạn đầu khoảng 200 ký tự (strip_tags để loại bỏ HTML khi cắt)
                $blogDesc = Str::limit(strip_tags($blog->DescriptionBlog), 100);
            @endphp
            <p>{!! $blogDesc !!}</p>
        </div>
    </div>
</a>