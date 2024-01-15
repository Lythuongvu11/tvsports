@extends('client.layouts.app')

@section('content')
    <!-- Carousel Start -->
    <div class="">
        <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $index => $banner)
                    <li data-target="#header-carousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($banners as $index => $banner)
                    <div class="carousel-item position-relative {{ $index === 0 ? 'active' : '' }}" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="{{ asset($banner->image) }}" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{ $banner->title }}</h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{ $banner->description }}</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="{{ $banner->link }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Sản phẩm chất lượng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Miễn phí vận chuyển</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hoàn trả trong 14 ngày</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <!-- Products Sale Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm Sale</span></h2>
        <div class="row px-xl-5">
            @foreach( $productsSale as $saleProduct)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4 d-flex flex-column" style="min-height: 500px;">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset($saleProduct->image) }}" alt="" style="max-width: 100%; height: auto;">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('client.product.show',$saleProduct->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                @if($saleProduct->sale > 0)
                                    <div class="discount-badge">-{{$saleProduct->sale}}%</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center py-4 mt-auto">
                            <a class="h6 text-decoration-none" href="{{ route('client.product.show',$saleProduct->id) }}">{{$saleProduct->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{number_format($saleProduct->price, 0, '', ',')}}đ</h5><h6 class="text-muted ml-2"><del>{{ number_format($saleProduct->price + ($saleProduct->price * $saleProduct->sale / 100), 0, '', ',') }}đ</del></h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('client.home.sale') }}" class="text-danger">Xem tất cả ></a>
        </div>
    </div>
    <!-- Products Sale End -->

    <!-- Products HOT Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm HOT</span></h2>
        <div class="row px-xl-5">
            @foreach( $productsHot as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1" >
                    <div class="product-item bg-light mb-4 d-flex flex-column" style="min-height: 500px;">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset($product->image) }}" alt="" style="max-width: 100%; height: auto;">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('client.product.show',$product->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                @if($product->sale > 0)
                                    <div class="discount-badge">-{{$product->sale}}%</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center py-4 mt-auto">
                            <a class="h6 text-decoration-none" href="{{ route('client.product.show',$product->id) }}">{{$product->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{number_format($product->price, 0, '', ',')}}đ</h5><h6 class="text-muted ml-2"><del>{{ number_format($product->price + ($product->price * $product->sale / 100), 0, '', ',') }}đ</del></h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('client.home.hot') }}" class="text-danger">Xem tất cả ></a>
        </div>
    </div>
    <!-- Products HOT End -->


    <!-- Products New Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm mới</span></h2>
        <div class="row px-xl-5">
            @foreach( $productsNew as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4 d-flex flex-column" style="min-height: 500px;">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset($item->image) }}" alt="" style="max-width: 100%; height: auto;">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="{{ route('client.product.show',$item->id) }}"><i class="fa fa-shopping-cart"></i></a>
                                @if($item->sale > 0)
                                    <div class="discount-badge">-{{$item->sale}}%</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center py-4 mt-auto">
                            <a class="h6 text-decoration-none" href="{{ route('client.product.show',$item->id) }}">{{$item->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{number_format($item->price, 0, '', ',')}}đ</h5><h6 class="text-muted ml-2"><del>{{ number_format($item->price + ($item->price * $item->sale / 100), 0, '', ',') }}đ</del></h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('client.home.new') }}" class="text-danger">Xem tất cả ></a>
        </div>
    </div>
    <!-- Products New End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="bg-light p-4">
                        <a href="https://www.nike.com/vn/">
                            <img src="{{ asset('client/img/nike.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://us.puma.com/us/en">
                            <img src="{{ asset('client/img/puma.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://www.adidas.com.vn/vi/">
                            <img src="{{ asset('client/img/adidas.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://reebok.com.vn/">
                            <img src="{{ asset('client/img/reebok.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://www.newbalance.com/">
                            <img src="{{ asset('client/img/newbalence.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://www.mizuno.com.vn/">
                            <img src="{{ asset('client/img/mizuno.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://www.underarmour.com/en-us/">
                            <img src="{{ asset('client/img/underarmour.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="bg-light p-4">
                        <a href="https://www.brooksrunning.com/en_us">
                            <img src="{{ asset('client/img/brooks.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const categories = document.querySelectorAll('.category-list > li');

                categories.forEach(category => {
                    const categoryChildren = category.querySelector('.category-children');

                    if (categoryChildren) {
                        category.addEventListener('mouseenter', function() {
                            categoryChildren.classList.add('show');
                        });

                        category.addEventListener('mouseleave', function() {
                            categoryChildren.classList.remove('show');
                        });
                    }
                });
            });
        </script>
    <!-- Vendor End -->
@endsection
