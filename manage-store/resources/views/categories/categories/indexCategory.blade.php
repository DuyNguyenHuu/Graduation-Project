@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Category</p>
            </div>
            <div>
                <a href="categories/create" role="button" style="text-decoration: none">Add</a>
            </div>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>ID Category</th>
                    <th>Name Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($categoryList as $row)
                    <tr>
                        <td>{{ $row->IdCategory }}</td>
                        <td>{{ $row->NameCategory }}</td>
                        @if ($row->Status==1)
                            <td>Enabled</td>
                        @else
                            <td>Disabled</td>
                        @endif
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <div><a href="categories/{{ $row->IdCategory }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                                <div>
                                    <form action="/categories/{{ $row->IdCategory }}" method="POST">
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