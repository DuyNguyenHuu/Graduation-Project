{{-- components/product_box.blade.php --}}
<div class="productTemplate">
    <div class="productImage">
        <img src="{{ asset($product->ImageURL) }}" alt="{{ $product->NameProduct }}" width="100%">
        <div class="discount-badge">
            @if ($product->OldPrice == 0)
                New
            @else
                -{{ round(100 - ($product->NewPrice / $product->OldPrice * 100)) }}%
            @endif
        </div>
    </div>
    <div class="productName">
        <a href="/products/{{ $product->IdProduct }}"><p>{{ $product->NameProduct }}</p></a>
    </div>
    <div class="price">
        @if ($product->OldPrice >0)
            <div class="oldPrice">
                ${{ $product->OldPrice }}
            </div>
        @endif
        <div class="newPrice">
            ${{ $product->NewPrice }}
        </div>
    </div>

    <!-- Các nút chức năng -->
    <div style="margin-top: 10px; display:flex; flex-direction: row; gap: 5px;justify-content:space-evenly">
        <!-- Nút Thêm vào giỏ hàng -->
        <div>
            <form method="POST">
                @csrf
                <button type="submit" style="background-color: #3F5D45; color: white; border: none; padding: 5px; cursor: pointer;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>
            </form>
        </div>

        <!-- Nút Yêu thích -->
        <div>
            <form method="POST">
                @csrf
                <button type="submit" style="background-color: #3F5D45; color: white; border: none; padding: 5px; cursor: pointer;">
                    <i class="fa-solid fa-heart"></i>
                </button>
            </form>
        </div>

        <!-- Nút So sánh -->
        <div>
            <form method="POST">
                @csrf
                <button type="submit" style="background-color: #3F5D45; color: white; border: none; padding: 5px; cursor: pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
    </div>
</div>
