@extends('layouts.template')

@section('content')
    @if (session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="detailProduct">
        <div style="display: flex; justify-content: space-between;">
            <div class="imageProduct">
                <img src="{{ asset($DetailProduct->ImageURL) }}" alt="{{ $DetailProduct->NameProduct }}" width="100%">
                <div class="typeProduct">{{ $DetailProduct->TypeProduct }}</div>
                <div class="discountProduct">
                    @if ($DetailProduct->OldPrice == 0)
                        New
                    @else
                        -{{ round(100 - ($DetailProduct->NewPrice / $DetailProduct->OldPrice * 100)) }}%
                    @endif
                </div>
            </div>
            <div class="infoProduct">
                <div class="nameProduct">{{ $DetailProduct->NameProduct }}</div>
                <div style="display: flex;">
                    @if ($DetailProduct->OldPrice >0)
                        <div class="old-price">
                            ${{ $DetailProduct->OldPrice }}
                        </div>
                    @endif
                    <div class="new-price">
                        ${{ $DetailProduct->NewPrice }}
                    </div>
                </div>
                <div class="shortDescription">
                    @php
                        use Illuminate\Support\Str;
                        // Lấy đoạn đầu khoảng 200 ký tự (strip_tags để loại bỏ HTML khi cắt)
                        $shortDesc = Str::limit(strip_tags($DetailProduct->Description), 200);
                    @endphp
                    {!! $shortDesc !!}
                    <a href="#description" style="color:#3F5D45; text-decoration: none;">Read more</a>
                </div>
                <form style="margin-bottom: 2em" method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    @if ($optionProduct != null)
                        <div class="optionProduct">
                            @php
                                $hasSize = $optionProduct->where('OptionProduct', 'SIZE')->isNotEmpty();
                                $hasType = $optionProduct->where('OptionProduct', 'TYPE')->isNotEmpty();
                            @endphp
                            @if ($hasSize)
                                <div class="size">
                                    <label>Size</label><br>
                                    <select name="optionSize" id="optionSize">
                                        @foreach ($optionProduct as $row)
                                            @if($row->OptionProduct == 'SIZE')
                                                <option value="{{ $row->IdOption }}" data-bonus-price="{{ $row->BonusPrice }}"
                                                    @if($row->Quantity == 0) disabled @endif>
                                                    {{ $row->SubOption }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if ($hasType)
                                <div class="option">
                                    <label>Type</label><br>
                                    <select name="optionType" id="optionType">
                                        @foreach ($optionProduct as $row)
                                            @if($row->OptionProduct == 'TYPE')
                                                <option value="{{ $row->IdOption }}" data-bonus-price="{{ $row->BonusPrice }}"
                                                    @if ($row->Quantity == 0) disabled @endif>
                                                    {{ $row->SubOption }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if ($hasSize==null)
                        <input type="hidden" name="optionSize" value="">
                    @elseif ($hasType==null)
                        <input type="hidden" name="optionType" value="">
                    @endif
                    <input type="hidden" name="product_id" value="{{ $DetailProduct->IdProduct }}">
                    <input type="hidden" name="product_price" class="final-price-input" value="{{ $DetailProduct->NewPrice }}">
                    <input type="number" name="product_quantity" value="1" min="1" style="text-align: center;height: 3em;">
                    <button type="submit" name="action" value="add" style="width: 10em; height:3em;background-color: #3F5D45; color: white; border-color: white; border-radius: 5px;">
                        Add to Cart
                    </button>
                </form>
                <form>
                    @csrf
                    <input type="hidden" name="idProduct" value="{{ $DetailProduct->IdProduct }}">
                    <button type="submit" name="action" value="wishlist" style="width: 10em; height:3em; background-color: #3F5D45; color: white; border-color: white; border-radius: 5px;">
                        WishList
                    </button>
                    <button type="submit" name="action" value="Compare" style="width: 10em; height:3em;background-color: #3F5D45; color: white; border-color: white; border-radius: 5px;">
                        Compare
                    </button>
                </form>
                <div class="categoryProduct">
                    @if ($DetailProduct->SubCategory==null)
                        @foreach ($getCategory as $row)
                            @if ($row->IdCategory == $DetailProduct->Category)
                                Category: <a href="" style="text-decoration: none; color: #3F5D45">{{ $row->NameCategory }}</a><br>
                            @endif
                        @endforeach
                    @else
                        @foreach ($getSubCategory as $row)
                            @if ($row->IdSub == $DetailProduct->SubCategory && $row->IdSubCategory == $DetailProduct->Category)
                                Category: <a href="" style="text-decoration: none; color: #3F5D45">{{ $row->NameCategory }} / {{ $row->Name }}</a><br>
                            @endif
                        @endforeach
                    @endif
                    Tags: {{ $DetailProduct->Tag }}
                </div>
            </div>
        </div>
        <div class="description">
            <div class="tab-buttons">
                <button class="tab-button active" onclick="showTab('description')">Description Product</button>
                <button class="tab-button" onclick="showTab('shipping')">Shipping</button>
            </div>
            <div id="description" class="tab-content active">
                {!! $DetailProduct->Description !!}
            </div>
            <div id="shipping" class="tab-content">
                {!! $getShipping->Detail !!}
            </div>
            <script>
                function showTab(tabId) {
                // Ẩn tất cả tab
                document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));

                // Hiển thị tab được chọn
                document.getElementById(tabId).classList.add('active');
                event.target.classList.add('active');
                }
            </script>
            <script>
                const basePrice = {{ $DetailProduct->NewPrice }};
                const newPriceEl = document.querySelector('.new-price');
                const priceInput = document.querySelector('.final-price-input');

                function updatePrice() {
                    let totalBonus = 0;

                    const selectedSize = document.querySelector('#optionSize');
                    const selectedType = document.querySelector('#optionType');

                    if (selectedSize && selectedSize.value !== "") {
                        const sizeBonus = parseInt(selectedSize.options[selectedSize.selectedIndex].dataset.bonusPrice || 0);
                        totalBonus += sizeBonus;
                    }

                    if (selectedType && selectedType.value !== "") {
                        const typeBonus = parseInt(selectedType.options[selectedType.selectedIndex].dataset.bonusPrice || 0);
                        totalBonus += typeBonus;
                    }

                    const finalPrice = basePrice + totalBonus;
                    newPriceEl.innerText = '$' + finalPrice.toLocaleString();
                    if (priceInput) {
                        priceInput.value = finalPrice;
                    }
                }

                // Gắn sự kiện thay đổi cho cả hai dropdown nếu tồn tại
                document.addEventListener('DOMContentLoaded', function () {
                    const sizeSelect = document.getElementById('optionSize');
                    const typeSelect = document.getElementById('optionType');

                    if (sizeSelect) sizeSelect.addEventListener('change', updatePrice);
                    if (typeSelect) typeSelect.addEventListener('change', updatePrice);

                    updatePrice(); // Cập nhật ban đầu nếu có giá trị chọn sẵn
                });
            </script>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div class="reviewProduct">
                <form method="POST" action="{{ route('submitReview', ['idProduct' => $DetailProduct->IdProduct]) }}" id="reviewForm">
                    @csrf
                    <label for="evaluate">Rate:</label>
                    <div id="star-rating" style="display: inline-block;">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}" style="font-size: 28px; color: #ccc; cursor: pointer;">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="evaluate" id="evaluate" value="0">
                    <br><br>
                    <textarea name="comment" rows="2" cols="50" placeholder="Write your review..."></textarea><br>
                    <button type="submit">Submit Review</button>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const stars = document.querySelectorAll('.star');
                        const input = document.getElementById('evaluate');
                        const form = document.getElementById('reviewForm');
                        let selectedValue = 0;

                        stars.forEach(star => {
                            star.addEventListener('mouseover', function () {
                                const value = parseInt(this.dataset.value);
                                stars.forEach(s => s.classList.toggle('hover', parseInt(s.dataset.value) <= value));
                            });

                            star.addEventListener('mouseout', () => {
                                stars.forEach(s => s.classList.remove('hover'));
                            });

                            star.addEventListener('click', function () {
                                selectedValue = parseInt(this.dataset.value);
                                input.value = selectedValue;
                                stars.forEach(s => s.classList.toggle('selected', parseInt(s.dataset.value) <= selectedValue));
                            });
                        });

                        form.addEventListener('submit', function (e) {
                            if (parseInt(input.value) === 0) {
                                e.preventDefault();
                                alert('Vui lòng chọn số sao để đánh giá!');
                            }
                        });
                    });
                </script>
                <h3>Latest Reviews</h3>
                @foreach ($reviewProduct as $row)
                    @if ($row->Status == 1)
                        <div class="reviewDetail">
                            <strong>{{ $row->Name }}</strong> - <em>{{ $row->created_at }}</em><br>
                            @for ($i=1; $i<=5; $i++)
                                @if ($i <= $row->Evaluate)
                                    <span style="color: gold;">&#9733;</span>
                                @else
                                    <span style="color: #ccc;">&#9733;</span>
                                @endif
                            @endfor
                            <p>{{ $row->Comments }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="rateProduct">
                <div class="review-summary">
                    <h3>Rating Product</h3>
                    <div style="display:flex; align-items:center; gap:15px;">
                        <div style="font-size:30px; font-weight:bold;">
                            {{ $avgRating }} <span style="font-size:20px;">⭐</span>
                        </div>
                        <div>
                            Total: {{ count($reviewProduct) }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="rating-bars">
                    @for ($i = 5; $i >= 1; $i--)
                        @php
                            $percent = count($reviewProduct) > 0
                                ? ($starCount[$i] / count($reviewProduct)) * 100
                                : 0;
                        @endphp

                        <div style="display:flex; align-items:center; margin-bottom:5px;">
                            <span style="width:50px; display:flex; align-items:center; gap:3px;">
                                <span>{{ $i }}</span>
                                <span>⭐</span>
                            </span>
                            <div style="width:200px; height:10px; background:#e5e5e5; margin: 0 10px;">
                                <div style="width:{{ $percent }}%; height:100%; background:#f8b600;"></div>
                            </div>
                            <span>{{ $starCount[$i] }}</span>
                        </div>
                    @endfor
                    </div>
                    <hr>
            </div>
        </div>
        <div class="product-container" style="background-color: white;padding: 1em; border-radius: 10px; margin-top: 2em;">
            <button class="arrow arrow-left" id="leftArrow" onclick="scrollProducts(-1)" disabled>&#8592;</button>
            <h4>Recommended Products</h4>
            <div class="product-list">
                @forelse ($recommendedProducts as $row)
                    <div class="product-item">
                        @include('components.product_box', ['product' => $row])
                    </div>
                @empty
                    <p>No products were recommended.</p>
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
