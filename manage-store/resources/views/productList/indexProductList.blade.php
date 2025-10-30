@extends('layouts.home')
@section('content')
<div class="background">
    <div class="Add">
        <div>
            <p>Product</p>
        </div>
        <div>
            <a href="productList/create" role="button" style="text-decoration: none">Add</a>
        </div>
    </div>

    <div>
        <form method="GET" action="/productList">
            <div class="filter">
                <div>
                    <label>Type Product</label><br>
                    <select name="filterType">
                        <option value="">Type Product</option>
                        <option value="Undefine Product"{{ request('filterType') == 'Undefine Product' ? 'selected' : '' }}>Undefine Product</option>
                        <option value="New Arrival"{{ request('filterType') == 'New Arrival' ? 'selected' : '' }}>New Arrival</option>
                        <option value="Flash Deal"{{ request('filterType') == 'Flash Deal' ? 'selected' : '' }}>Flash Deal</option>
                        <option value="Best Product"{{ request('filterType') == 'Best Product' ? 'selected' : '' }}>Best Product</option>
                        <option value="Top Product"{{ request('filterType') == 'Top Product' ? 'selected' : '' }}>Top Product</option>
                    </select>
                </div>
                <div>
                    <label>Category</label><br>
                    <select id="category" name="filterCategory" onchange="filterSubCategories()">
                        <option value="">Category</option>
                        @foreach ($categoryList as $row)
                            <option value="{{ $row->IdCategory }}" {{ request('filterCategory') == $row->IdCategory ? 'selected' : '' }}>
                                {{ $row->NameCategory }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Sub Category</label><br>
                    <select id="subcategory" name="filterSub">
                        <option value="">Sub Category</option>
                        @foreach ($subCategoryList as $row)
                        <option value="{{ $row->IdSub }}"   {{ request('filterSub') == $row->IdSub ? 'selected' : '' }} data-category="{{ $row->IdSubCategory }}">{{ $row->Name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Status Product</label><br>
                    <select name="filterStatus">
                        <option value="" {{ request('filterStatus') === 'Publish' ? 'selected' : '' }}>Status Product</option>
                        <option value="Publish" {{ request('filterStatus') === 'Publish' ? 'selected' : '' }}>Publish</option>
                        <option value="UnPublish" {{ request('filterStatus') === 'UnPublish' ? 'selected' : '' }}>UnPublish</option>
                    </select>
                </div>
                <div>
                    <label>Search Product</label><br>
                    <input type="text" name="filterName" placeholder="Enter product name" value="{{ request('filterName') }}">
                </div>
                <button type="submit">Search</button>
            </div>
        </form>
        <script>
            function filterSubCategories() {
                const selectedCategory = document.getElementById("category").value;
                const subcategorySelect = document.getElementById("subcategory");
                const options = subcategorySelect.options;

                for (let i = 0; i < options.length; i++) {
                    const option = options[i];
                    const belongsTo = option.getAttribute("data-category");
        
                    if (!belongsTo || selectedCategory === "") {
                        option.style.display = "";
                    } else {
                        option.style.display = (belongsTo === selectedCategory) ? "" : "none";
                    }
                }

                subcategorySelect.value = ""; // Reset selection
            }
        </script>
    </div>

    <div class="Table">
        <table>
            <tr>
                <th><input type="checkbox"></th>
                <th>Image</th>
                <th>Name</th>
                <th>Type Product</th>
                <th>New Price</th>
                <th>Old Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                @foreach ($productList as $row)
                    <tr>
                        <td><input type="checkbox" value="{{ $row->IdProduct }}"></td>
                        <td><img style="width:50px"src="{{ $row->ImageURL }}"></td>
                        <td>{{ $row->NameProduct }}</td>
                        <td>{{ $row->TypeProduct }}</td>
                        <td>{{ $row->NewPrice }}</td>
                        <td>{{ $row->OldPrice }}</td>
                        <td>{{ $row->StatusProduct }}</td>
                        <td>
                            <div style="display:flex;justify-content:space-evenly">
                                <select class="optionProduct" onchange="goToPage(this)" data-id="{{ $row->IdProduct }}">
                                    <option>Option</option>
                                    <option value="{{ route('productList.edit', ['productList' => $row->IdProduct]) }}">Edit</option>
                                    <option value="{{ route('productList.attribute', ['productList' => $row->IdProduct]) }}">Attributes</option>
                                    <option value="delete">Delete</option> {{-- sử dụng "delete" để JS nhận biết --}}
                                </select>
                                <div>
                                    <form id="delete-form-{{ $row->IdProduct }}" action="/productList/{{ $row->IdProduct }}" style="display:none"method="POST">
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
        <div style="margin-top: 20px">
            <div class="d-flex justify-content-center mt-4">
                {{ $productList->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    <script>
        function goToPage(selectElement) {
            const selectedValue = selectElement.value;
            const id = selectElement.getAttribute('data-id');

            if (selectedValue === 'delete') {
                if (confirm("Are you sure you want to delete this item?")) {
                    const form = document.getElementById('delete-form-' + id);
                    if (form) {
                        form.submit();
                    }
                }
            } else if (selectedValue && selectedValue !== 'Option') {
                window.location.href = selectedValue;
            }

            // Reset select back to "Option" sau khi xử lý
            selectElement.selectedIndex = 0;
        }
    </script>
</div>
@endsection