@extends('layouts.template')
@section('content')
    <div class="chooseBlog">
        <div class="menuBlog">
            <div class="filter">
                <div>
                    <form>
                        <input type="text" name="searchBlog" style="box-sizing: border-box;"placeholder="Search blog">
                        <button type="submit">Search</button>
                    </form>
                </div>
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
        <div style="width:80%">
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