@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Category</p>
            </div>
            <div>
                <a href="subcategories/create" role="button" style="text-decoration: none">Add</a>
            </div>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @foreach ($subCategoryList as $row)
                    <tr>
                        <td>{{ $row->NameCategory }}</td>
                        <td>{{ $row->Name }}</td>
                        @if ($row->StatusSub==1)
                            <td>Enabled</td>
                        @else
                            <td>Disabled</td>
                        @endif
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <div>
                                    <form action="subcategories/{{ $row->IdSub }}/edit" METHOD="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <input name="hiddenIdCategory" type="hidden" value="{{ $row->IdCategory }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <form action="/subcategories/{{ $row->IdSub }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <input name="idCategory" type="hidden" value="{{ $row->IdCategory }}">
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