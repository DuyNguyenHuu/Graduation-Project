@extends('layouts.home')
@section('content')
    <div class="background">
        <div class="Add">
            <div class="title">
                <p>User</p>
            </div>
            <div>
            </div>
        </div>
        <div>
            <form method="GET" action="{{ url('/users') }}" >
                <div class="filter">
                    <div>
                        <label>Search</label><br>
                        <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search Name, Email or Phone">
                    </div>
                    <div>
                        <label>All Role</label><br>
                        <select name="role">
                            <option value="">All Role</option>
                            <option value="1" {{ request('role') === '1' ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ request('role') === '0' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div>
                        <label>All Status</label><br>
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <div>
                        <label>From Date</label><br>
                        <input type="date"
                        name="from_date"
                        value="{{ request('from_date') }}">
                    </div>
                    <div>
                        <label>To Date</label><br>
                        <input type="date"
                        name="to_date"
                        value="{{ request('to_date') }}">
                    </div>
                    <button type="submit">Filter</button>
                </div>
            </form>
        </div>
        <div class="Table">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Create_at</th>
                    <th>Actions</th>
                </tr>
                @foreach ($getUser as $row)
                <tr>
                    <td>{{ $row->Name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->Phone }}</td>
                    @if ($row->ROLE == 1)
                        <td style="color: #E74C3C">Admin</td>
                    @else
                        <td style="color: #3498DB">User</td>
                    @endif
                    @if ($row->Status == 1)
                        <td style="color: green">Enabled</td>
                    @else
                        <td style="color: red">Disabled</td>
                    @endif
                    <td>{{ $row->created_at }}</td>
                    <td>
                        <div style="display:flex;justify-content:space-evenly">
                            <div><a href="users/{{ $row->IdUser }}/edit"><i class="fa-solid fa-pencil"></i></a></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getUser->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div id="toastsuccess">
            {{ session('success') }}
        </div>

        <script>
            const toast = document.getElementById('toastsuccess');
            setTimeout(() => { toast.style.opacity = 1; }, 100);
            setTimeout(() => { toast.style.opacity = 0; }, 3000);
        </script>
    @endif

@endsection