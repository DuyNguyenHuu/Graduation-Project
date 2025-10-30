@extends('layouts.template')
@section('content')
    <div class="detailBlog">
        <div class="headerBlog">{{ $detailBlog->Blog }}</div>
        <div class="subHeaderBlog">
            <div>
                <a href="{{ url('/blogs?category=' . $detailBlog->IdBCategory) }}">
                    <i class="fa-solid fa-tag"></i>
                    {{ $detailBlog->BCategory }}
                </a>
            </div>
            <div>
                <i class="fa-solid fa-clock"></i>
                {{ $detailBlog->updated_at }}
            </div>
        </div>
        <hr>
        <div class="mainBlog">
            {!! $detailBlog->DescriptionBlog !!}
        </div>
    </div>
@endsection