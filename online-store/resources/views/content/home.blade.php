@extends('layouts.template')

@section('content')
    <div class="popularCategory">
        <form method="GET" action="{{ route('home') }}" id="categoryForm">
            <div style="display:flex; justify-content: space-between;">
                <div><h4>Popular Categories</h4></div>
                <div>
                    <label>Category</label><br>
                    <select name="productCategory" onchange="document.getElementById('categoryForm').submit();">
                        <option value="">Category</option>
                        @foreach ($getCategory as $row)
                            <option value="{{ $row->IdCategory }}"
                                {{ request('productCategory') == $row->IdCategory ? 'selected' : '' }}>
                                {{ $row->NameCategory }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <div class="product-container">
            <button class="arrow arrow-left" id="leftArrow" onclick="scrollProducts(-1)" disabled>&#8592;</button>
            <div class="product-list">
                @forelse ($getProduct as $row)
                    <div class="product-item">
                        @include('components.product_box', ['product' => $row])
                    </div>
                @empty
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                @endforelse
            </div>
            <button class="arrow arrow-right" id="rightArrow" onclick="scrollProducts(1)">&#8594;</button>
        </div>
        <script>
            const productList = document.querySelector('.product-list');
            const leftArrow = document.getElementById('leftArrow');
            const rightArrow = document.getElementById('rightArrow');
            const productWidth = document.querySelector('.product-item').offsetWidth + 20; // Chiều rộng mỗi sản phẩm + khoảng cách
            let currentTransform = 0; // Biến lưu vị trí hiện tại

            // Hàm cuộn sản phẩm
            function scrollProducts(direction) {
                const maxScrollWidth = productList.scrollWidth - productList.clientWidth; // Đo chiều dài danh sách sản phẩm trừ đi chiều rộng vùng hiển thị
                currentTransform += direction * productWidth;

                // Giới hạn cuộn
                if (currentTransform < 0) {
                    currentTransform = 0; // Không cuộn qua trái quá
                } else if (currentTransform > maxScrollWidth) {
                    currentTransform = maxScrollWidth; // Không cuộn qua phải quá
                }

                // Áp dụng biến hiện tại vào transform
                productList.style.transform = `translateX(-${currentTransform}px)`;

                // Cập nhật trạng thái các mũi tên
                updateArrowState(currentTransform, maxScrollWidth);
            }

            // Hàm cập nhật trạng thái mũi tên
            function updateArrowState(currentTransform, maxScrollWidth) {
                // Nếu cuộn đến đầu, vô hiệu hóa mũi tên trái
                leftArrow.disabled = currentTransform === 0;
                leftArrow.classList.toggle('disabled', currentTransform === 0);

                // Nếu cuộn đến cuối, vô hiệu hóa mũi tên phải
                rightArrow.disabled = currentTransform === maxScrollWidth;
                rightArrow.classList.toggle('disabled', currentTransform === maxScrollWidth);
            }

            // Gọi hàm để kiểm tra trạng thái ban đầu khi trang tải
            updateArrowState(currentTransform, productList.scrollWidth - productList.clientWidth);
        </script>
    </div>
@endsection
