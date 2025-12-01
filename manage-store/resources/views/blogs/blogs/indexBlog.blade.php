@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Blog</p>
            </div>
            <div style="display:flex; gap: 3em">
                <form method="GET" action="">
                    <input type="text" name="search" placeholder="Search Blog..." value="{{ $search ?? '' }}">
                    <button type="submit">Search</button>
                </form>

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
                            <td style="color:green">Publish</td>
                        @else
                            <td style="color:red">UnPublish</td>
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
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getBlog->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection