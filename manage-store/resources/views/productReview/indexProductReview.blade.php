@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add" style="display: flex; justify-content: space-around; align-items: center;">
        <div>
            <p>Product Review</p>
        </div>
        <div>
            <form action="{{ route('productReview.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search..."
                    value="{{ request('search') }}" 
                    style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px;">Search</button>
            </form>
        </div>
    </div>
    <div class="Table">
        <table>
            <tr>
                <th>Name</th>
                <th>Product</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                @foreach ($productReview as $row)
                    <tr>
                        <td>{{ $row->Name }}</td>
                        <td>{{ $row->NameProduct }}</td>
                        <td>{{ $row->Evaluate }}</td>
                        @if ($row->Status==1)
                            <td style="color:green">Enabled</td>
                        @elseif ($row->Status==0)
                            <td style="color: red">Disabled</td>
                        @else
                            <td style="color: #3498DB">Pending</td>
                        @endif
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <div><a href="productReview/{{ $row->IdReview }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                                <div>
                                    <form action="/productReview/{{ $row->IdReview }}" method="POST" onsubmit="return confirm('Are you sure to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color:red;border:none;background:none;cursor:pointer;">
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
                {{ $productReview->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection