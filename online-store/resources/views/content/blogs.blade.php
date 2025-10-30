@extends('layouts.template')
@section('content')
    <div class="chooseBlog">
        <div class="menuBlog">
            <div style="background-color: white; padding: 1em; margin-bottom: 2em;">
                <input type="text" name="searchBlog" style="width:12em;"placeholder="Search blog">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div style="background-color: white; padding: 1em">
                <div style="font-weight: bold; font-size: 18px;">
                    <a href="/blogs">Blog Category</a>
                </div>
                <hr>
                <div>
                    @foreach ($getBCategory as $row)
                        <a href="{{ url('/blogs?category=' . $row->IdBCategory) }}">->{{ $row->BCategory }}</a><br>
                    @endforeach
                </div>
            </div>
        </div>
        <div>
            <div class="listBlog">
                @foreach ($getBlog as $blog)
                    <div>
                        @include('components.blog_box', ['blog' => $blog])
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getBlog->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection