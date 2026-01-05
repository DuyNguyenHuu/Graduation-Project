<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="{{ url('/') }}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="{{ url('dashBoard') }}" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Manage Categories</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="{{ url('categories') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Categories</span></a>
                                </li>
                                <li>
                                    <a href="{{ url('subcategories') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Sub Categories</span></a>
                                </li>
                            </ul>
                    </li>
                    <li>
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Manage Products</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="{{ url('productList') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">All Product</span></a>
                            </li>
                            <li>
                                <a href="{{ url('productReviews') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Product Review</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Manage Blogs</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="{{ url('bcategories') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Categories</span></a>
                            </li>
                            <li>
                                <a href="{{ url('blogs') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Blogs</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('orders') }}" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Manage Orders</span> </a>
                    </li>
                    <li>
                        <a href="#submenu5" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Manage Ecommerce</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu5" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="{{ url('coupons') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Coupons</span></a>
                            </li>
                            <li>
                                <a href="" class="nav-link px-0"> <span class="d-none d-sm-inline">Banner</span></a>
                            </li>
                            <li>
                                <a href="{{ url('shippings') }}" class="nav-link px-0"> <span class="d-none d-sm-inline">Shipping Info</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('users') }}" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">
                            @if (Auth::check())
                                {{ Auth::user()->Name }}
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">
                            @if (Auth::check())
                                {{ Auth::user()->Name }}
                            @endif
                        </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col py-3">
            @yield('content')
        </div>
    </div>
</div>
