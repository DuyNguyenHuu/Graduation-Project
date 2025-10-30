@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div>
                <p>Category</p>
            </div>
            <div>
                <a href="/productList/{{$productList}}/attributes/create" role="button" style="text-decoration: none">Add</a>
                <a href="/productList" role="button" style="text-decoration: none">Back</a>
            </div>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Option Product</th>
                    <th>Sub Option</th>
                    <th>Quantity</th>
                    <th>Bonus Price</th>
                    <th>Actions</th>
                </tr>
                @foreach ($optionProduct as $row)
                    <tr>
                        <td>{{ $row->OptionProduct }}</td>
                        <td>{{ $row->SubOption }}</td>
                        <td>{{ $row->Quantity }}</td>
                        <td>{{ $row->BonusPrice }}</td>
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <div><a href="/productList/{{ $productList }}/attributes/{{ $row->IdOption }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                                <div>
                                    <form action="{{ route('productList.destroyAttribute', ['productList' => $productList, 'idOption' => $row->IdOption]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Delete
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