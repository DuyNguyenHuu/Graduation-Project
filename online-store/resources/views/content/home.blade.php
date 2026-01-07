@extends('layouts.template')

@section('content')
    <div class="popularCategory">
        <div class="product-section">
            <h4>Item Recommended Products For You</h4>
            <div class="product-container">
                <button class="arrow arrow-left" onclick="scrollProducts(this, -1)" disabled>&#8592;</button>
                <div class="product-list">
                    @forelse ($itemRecommendations as $row)
                        <div class="product-item">
                            @include('components.product_box', ['product' => $row])
                        </div>
                    @empty
                        <p>No products.</p>
                    @endforelse
                </div>
                <button class="arrow arrow-right" onclick="scrollProducts(this, 1)">&#8594;</button>
            </div>
        </div>

        <div class="product-section">
            <h4>User Recommended Products For You</h4>
            <div class="product-container">
                <button class="arrow arrow-left" onclick="scrollProducts(this, -1)" disabled>&#8592;</button>
                <div class="product-list">
                    @forelse ($userRecommendations as $row)
                        <div class="product-item">
                            @include('components.product_box', ['product' => $row])
                        </div>
                    @empty
                        <p>No products.</p>
                    @endforelse
                </div>
                <button class="arrow arrow-right" onclick="scrollProducts(this, 1)">&#8594;</button>
            </div>
        </div>

        <div class="product-section">
            <h4>Best Selling Products</h4>
            <div class="product-container">
                <button class="arrow arrow-left" onclick="scrollProducts(this, -1)" disabled>&#8592;</button>
                <div class="product-list">
                    @forelse ($getFrequentProduct as $row)
                        <div class="product-item">
                            @include('components.product_box', ['product' => $row])
                        </div>
                    @empty
                        <p>No products.</p>
                    @endforelse
                </div>
                <button class="arrow arrow-right" onclick="scrollProducts(this, 1)">&#8594;</button>
            </div>
        </div>

        <form method="GET" action="{{ route('home') }}" id="categoryForm">
            <div class="product-container" style="justify-content: space-between;">
                <h4>Popular Categories</h4>
                <select name="productCategory" onchange="this.form.submit()">
                    <option value="">Category</option>
                    @foreach ($getCategory as $row)
                        <option value="{{ $row->IdCategory }}"
                            {{ request('productCategory') == $row->IdCategory ? 'selected' : '' }}>
                            {{ $row->NameCategory }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="product-container">
            <button class="arrow arrow-left" onclick="scrollProducts(this, -1)" disabled>&#8592;</button>
            <div class="product-list">
                @forelse ($getProduct as $row)
                    <div class="product-item">
                        @include('components.product_box', ['product' => $row])
                    </div>
                @empty
                    <p>No products.</p>
                @endforelse
            </div>
            <button class="arrow arrow-right" onclick="scrollProducts(this, 1)">&#8594;</button>
        </div>
    </div>

    <script>
        function scrollProducts(button, direction) {
            const container = button.closest('.product-container');
            const productList = container.querySelector('.product-list');
            const leftArrow = container.querySelector('.arrow-left');
            const rightArrow = container.querySelector('.arrow-right');

            const scrollAmount = productList.clientWidth * 0.8;

            productList.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });

            setTimeout(() => {
                leftArrow.disabled = productList.scrollLeft <= 0;
                rightArrow.disabled =
                    productList.scrollLeft + productList.clientWidth >= productList.scrollWidth - 1;
            }, 300);
        }
    </script>

@endsection
