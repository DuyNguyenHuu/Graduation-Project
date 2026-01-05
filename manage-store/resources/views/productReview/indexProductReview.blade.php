@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add" style="display: flex; justify-content: space-around; align-items: center;">
            <div class="title">
                <p>Product Review</p>
            </div>
            <div></div>
        </div>
        <div>
            <form method="GET" action="{{ url('/productReviews') }}" >
                <div class="filter">
                    <div>
                        <label>Search</label><br>
                        <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search Title or Code">
                    </div>
                    <div>
                        <label>Rating</label><br>
                        <select name="evaluate">
                            <option value="">All Rating</option>
                            <option value="5" {{ request('evaluate') === '5' ? 'selected' : '' }}>5</option>
                            <option value="4" {{ request('evaluate') === '4' ? 'selected' : '' }}>4</option>
                            <option value="3" {{ request('evaluate') === '3' ? 'selected' : '' }}>3</option>
                            <option value="2" {{ request('evaluate') === '2' ? 'selected' : '' }}>2</option>
                            <option value="1" {{ request('evaluate') === '1' ? 'selected' : '' }}>1</option>
                        </select>
                    </div>
                    <div>
                        <label>Status</label><br>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Disabled</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <button type="submit">Filter</button>
                </div>
            </form>
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
                                    <div><a href="productReviews/{{ $row->IdReview }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                                    <div>
                                        <form action="/productReviews/{{ $row->IdReview }}" method="POST" onsubmit="return confirm('Are you sure to delete this review?');">
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
    @include('layouts.success')
@endsection