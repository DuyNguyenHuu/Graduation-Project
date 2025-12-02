<div>
    <div class="orderTracking">
        <div>
            <a href="" target="_blank" style="display:flex; text-decoration: none;">
                <i class="fa-solid fa-location-dot"></i>
                <p>Track Order</p>
            </a>
        </div>
        <div class="dropdown">
            @if (Auth::check())
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    👤 {{ Auth::user()->Name ?? Auth::user()->name }}
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu"
                    style="background-color: #ffffff; color: #000000; border-radius: 10px; min-width: 200px;">
                    
                    <li><h6 class="dropdown-header text-dark">{{ Auth::user()->email }}</h6></li>
                    <li><hr class="dropdown-divider"></li>

                    <li><a class="dropdown-item text-dark" href="{{ url('/profile') }}">Thông tin cá nhân</a></li>

                    <li>
                        <form method="GET" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            @else
                <a href="{{ url('/login') }}" class="btn btn-outline-primary">Sign in / Sign up</a>
            @endif
        </div>

    </div>
    <div class="header">
        <div class="logo">
            <a href="" target="_blank">
                <img style="height: 4em" src="https://phuongnamvina.com/img_data/images/design-logo-ban-hang-online.jpg">
            </a>
        </div>
        <div class="search" style="position: relative;">
            <input type="text" id="searchInput" placeholder="Search Product..." autocomplete="off">

            <div id="searchResult"
                style="position:absolute; top:38px; width:100%; background:white; border:1px solid #ddd; display:none; z-index:100;"></div>
        </div>
        <script>
            const searchInput = document.getElementById('searchInput');
            const searchResult = document.getElementById('searchResult');

            searchInput.addEventListener('keyup', function() {
                let query = this.value;

                if(query.length < 1) {
                    searchResult.style.display = "none";
                    return;
                }

                fetch("{{ route('searchProduct') }}?search=" + query)
                .then(res => res.json())
                .then(data => {
                    let html = '';

                    if(data.length > 0){
                        data.forEach(p => {
                            html += `
                                <div style="display:flex; align-items:center; padding:8px; gap:10px; cursor:pointer; border-bottom:1px solid #eee"
                                    onclick="window.location='/products/${p.IdProduct}'">

                                    <img src="${p.ImageURL}"
                                        style="width:45px; height:45px; object-fit:cover; border-radius:4px;">

                                    <div style="font-size:14px;">${p.NameProduct}</div>
                                </div>
                            `;
                        });
                    } else {
                        html = "<div style='padding:8px;'>No products</div>";
                    }

                    searchResult.innerHTML = html;
                    searchResult.style.display = "block";
                });
            });

            // Ẩn khi click ra ngoài
            document.addEventListener('click', function(e) {
                if(!searchInput.contains(e.target)) {
                    searchResult.style.display = "none";
                }
            });
        </script>

        <div class="check">
            <div style="text-align:center">
                <i class="fa-regular fa-heart"></i>
                <p>WishList</p>
            </div>
            <div style="text-align:center">
                <a style="text-decoration: none; color: black" href="{{ route('cart.view') }}"><i class="fa-solid fa-cart-shopping"></i>
                <p>Cart</p></a>
            </div>
        </div>
    </div>
</div>
<div class="menu">
    <div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
            </button>
            <ul class="dropdown-menu">
                @foreach ( $getCategory as $row)
                    <li ><button class="dropdown-item" type="button">{{ $row->NameCategory }}</button></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="menuDetail"><a href="{{ route('home') }}">Home</a></div>
    <div class="menuDetail"><a href="{{ route('products') }}">Products</a></div>
    <div class="menuDetail"><a href="{{ route('coupons') }}" >Coupons</a></div>
    <div class="menuDetail"><a href="{{ route('blogs') }}" >Blogs</a></div>
    <div class="menuDetail"><a href="{{ route('contacts.form') }}" >Contact</a></div>
</div>