<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') TVSports</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('client/img/logo1.png') }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Favicon -->
    <link href="{{ asset('client/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="{{ asset('https://fonts.gstatic.com') }}">
    <link href="{{ asset('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('client/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
    <link
        rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css')}}"
    />
</head>

<body>
<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-12 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    @if(auth('user')->check())
                        <!-- Hiển thị tên người dùng và nút đăng xuất -->
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                            {{ auth('user')->user()->name }} <!-- Thay "name" bằng trường tên thích hợp -->
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('user.profile') }}">Quản lý tài khoản</a>
                            <form method="POST" action="{{ route('user.logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Đăng xuất</button>
                            </form>
                        </div>
                    @else
                        <!-- Hiển thị nút "Đăng nhập" và "Đăng ký" -->
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Tài khoản</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">
                                <a href="{{ route('user.register')}}">Đăng ký</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <a href="{{ route('user.login') }}">Đăng nhập</a>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-3 d-flex justify-content-center">
            <a href="{{ route('client.home') }}">
                <img src="{{ asset('client/img/logo1.jpg') }}" alt="" class="img-fluid" width="100" height="100" >
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="{{ route('client.products.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Tìm kiếm">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0 px-0">
            <a href="{{ route('client.home') }} " class="text-decoration-none d-block d-lg-none">
                <img src="{{ asset('client/img/logo1.jpg') }}" alt="" class="img-fluid" width="100" height="100" >
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="{{ route('client.home') }}" class="nav-item nav-link {{ request()->is('/') || Route::currentRouteName() === 'client.home' ? 'active' : '' }}">Trang chủ</a>
                    <a href="{{ route('client.products.index') }}" class="nav-item nav-link {{ request()->is('client/products*') || request()->is('products*')|| request()->is('product-detail/*') ? 'active' : '' }}">Sản phẩm</a>
                    <a href="{{ route('blog') }}" class="nav-item nav-link {{ request()->is('blog*') ? 'active' : '' }}">Tin tức</a>
                    <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->is('contact*') ? 'active' : '' }}">Liên hệ</a>
                    @if(auth('user')->check())
                        <a href="{{ route('client.orders.index') }}" class="nav-link">Đơn hàng</a>
                    @endif
                </div>
                <div class="navbar-nav ml-4 py-0 d-none d-lg-block ">
{{--                    <a href="" class="btn px-0">--}}
{{--                        <i class="fas fa-heart text-primary"></i>--}}
{{--                        <span class="badge border rounded-circle" style="padding-bottom: 2px;">0</span>--}}
{{--                    </a>--}}
                    <a href="{{ route('client.carts.index') }}" class="btn px-0 ml-3">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <span class="badge  border rounded-circle" id="productCountCart"  style="padding-bottom: 2px;">{{ $countProductInCart}}</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="col-lg-12 d-flex justify-content-center flex-wrap bg-primary text-white">
    @if ($categories && count($categories) > 0)
        @foreach ($categories as $item)
            {{-- Hiển thị danh mục cấp 1 --}}
            @if ($item->parent_id == 0)
                <div class="nav-item mx-2 dropdown dropdown-submenu">
                    <a href="{{ route('client.products.index', ['category_id' => $item->id]) }}"
                       class="nav-link parent-category d-flex align-items-center">
                        {{ $item->name }}
                        @if ($item->children->isNotEmpty())
                            <i class="ml-2 fas fa-angle-down"></i>
                        @endif
                    </a>

                    @if ($item->children->isNotEmpty())
                        <ul id="category-{{ $item->id }}" class="sub-categories dropdown-menu">
                            @foreach ($item->children as $childCategory)
                                <li class="position-relative dropdown-submenu">
                                    <a href="{{ route('client.products.index', ['category_id' => $childCategory->id]) }}"
                                       class="dropdown-item nav-link">{{ $childCategory->name }}
                                        @if ($childCategory->children->isNotEmpty())
                                            <i class="ml-2 fas fa-angle-down"></i>
                                        @endif
                                    </a>

                                    @if ($childCategory->children->isNotEmpty())
                                        <ul id="category-{{ $childCategory->id }}" class="sub-sub-categories dropdown-menu dropdown-menu-end" style="margin-left: 201px;margin-top: -9px;top: 0px;display: none;">
                                            @foreach ($childCategory->children as $subChildCategory)
                                                <li class="position-relative">
                                                    <a href="{{ route('client.products.index', ['category_id' => $subChildCategory->id]) }}"
                                                       class="dropdown-item">{{ $subChildCategory->name }}</a>
                                                    <!-- Thêm các cấp độ lồng nhau nếu cần -->
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        @endforeach
    @else
        <p class="text-center">Không có danh mục nào.</p>
    @endif
</div>

<!-- Navbar End -->


@yield('content')


@include('client.layouts.footer')


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


<!-- JavaScript Libraries -->
<script src="{{ asset('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('client/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('client/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Contact Javascript File -->
<script src="{{ asset('client/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('client/mail/contact.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Swiper JS -->
<script src="{{ asset('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js') }}"></script>
<!-- Template Javascript -->
<script src="{{ asset('client/js/main.js') }}"></script>

</body>

</html>
