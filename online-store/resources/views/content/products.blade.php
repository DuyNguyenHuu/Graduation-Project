@extends('layouts.template')

@section('content')
<div>
    <div class="chooseProduct">
        <div class="menuProduct">
            <!-- Hiển thị danh mục-->
            <form method="GET" action="{{ route('products') }}">
                <button type="submit">Filter</button>
                <div class="priceFilter">
                    <label style="font-size:18px; font-weight:500">Price</label>

                    <div>
                        <input type="number" name="min_price" 
                            value="{{ request('min_price') }}"
                            placeholder="Min price">
                    </div>

                    <div>
                        <input type="number" name="max_price" 
                            value="{{ request('max_price') }}"
                            placeholder="Max price">
                    </div>
                </div>
                @foreach ($getCategory as $category)
                    <div>
                        <label style="font-size: 18px; font-weight:500">{{ $category->NameCategory }}</label><br>
                        <div>
                            @php
                                $filters = request('filter', []);
                                $isAllChecked = in_array($category->IdCategory, $filters)
                                    && collect($filters)->filter(fn($f) => str_starts_with($f, $category->IdCategory . ','))->isEmpty();
                            @endphp
                            <input type="checkbox" name="filter[]" value="{{ $category->IdCategory }}" {{ $isAllChecked ? 'checked' : '' }}>
                            <label>All</label>
                        </div>

                        @foreach ($getSubCategory as $subCategory)
                            @if ($category->IdCategory == $subCategory->IdSubCategory)
                                <div>
                                    <input type="checkbox" name="filter[]" value="{{ $category->IdCategory }},{{ $subCategory->IdSub }}"
                                        {{ in_array($category->IdCategory . ',' . $subCategory->IdSub, $filters) ? 'checked' : '' }}>
                                    <label>{{ $subCategory->Name }}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </form>
        </div>
        <div>
            <!-- Hiển thị sản phẩm -->
            <div class="listProduct">
                @foreach ($getProduct as $product)
                    <div class="product-item">
                        @include('components.product_box', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <!-- Thêm phân trang -->
            <div style="margin-top: 20px">
                <div class="d-flex justify-content-center mt-4">
                    {{ $getProduct->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection