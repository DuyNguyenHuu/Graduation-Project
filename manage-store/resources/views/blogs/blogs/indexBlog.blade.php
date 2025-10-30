@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Blog</p>
            </div>
            <div>
                <a href="blogs/create" role="button" style="text-decoration: none">Add</a>
            </div>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($getBlog as $row)
                    <tr>
                        <td><img style="width:50px"src="{{ $row->ImageBlog }}"></td>
                        <td>{{ $row->Blog }}</td>
                        <td>{{ $row->BCategory }}</td>
                        @if ($row->StatusBlog==1)
                            <td>Publish</td>
                        @else
                            <td>UnPublish</td>
                        @endif
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <div><a href="blogs/{{ $row->IdBlog }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                                <div>
                                    <form action="/blogs/{{ $row->IdBlog }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection