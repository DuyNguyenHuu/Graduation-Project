@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Category Blog</p>
            </div>
            <div>
                <a href="bcategories/create" role="button" style="text-decoration: none">Add</a>
            </div>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>ID Category Blog</th>
                    <th>Name Category Blog</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($bCategoryList as $row)
                    <tr>
                        <td>{{ $row->IdBCategory }}</td>
                        <td>{{ $row->BCategory }}</td>
                        @if ($row->StatusBCategory==1)
                            <td>Enabled</td>
                        @else
                            <td>Disabled</td>
                        @endif
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <div><a href="bcategories/{{ $row->IdBCategory }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                                <div>
                                    <form action="/bcategories/{{ $row->IdBCategory }}" method="POST">
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