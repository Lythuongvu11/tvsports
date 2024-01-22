@extends('client.layouts.app')
@section('title', 'Sản phẩm -')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('client.home') }}">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('client.products.index') }}">Sản phẩm</a>
                    @if (isset($selectedCategories))
                        @foreach($selectedCategories as $selectedCategory)
                            <a href="{{ route('client.products.index', $selectedCategory->id) }}" class="breadcrumb-item text-dark">{{ $selectedCategory->name }}</a>
                        @endforeach
                    @endif
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-3 mb-3 ">
                @if(isset($_GET['q']))
                    <div class="my-result">
                        <h5>Kết quả tìm kiếm cho <span class="font-italic">{{ $_GET['q'] }}</span></h5>
                    </div>
                @endif
                <div class="search-box">
                    <form action="{{route('client.products.index')}}" method="GET">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="q" placeholder="Tìm kiếm sản phẩm">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo giá</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        @foreach( range(1, 5) as $priceRange)
                            @php
                                if (isset($priceRanges)) {
                                    $minPrice = number_format($priceRanges[$priceRange]['min'], 0, '', ',');
                                    $maxPrice = number_format($priceRanges[$priceRange]['max'], 0, '', ',');
                                }
                            @endphp
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="price-{{ $priceRange }}" name="price[]" value="{{ $priceRange }}" {{ in_array($priceRange, $selectedPriceRange) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="price-{{ $priceRange }}">
                                    @if ($priceRange == 1)
                                        < {{ $maxPrice }}đ
                                    @elseif ($priceRange == 5)
                                        > {{ $minPrice }}đ
                                    @else
                                        {{ $minPrice }}đ - {{ $maxPrice }}đ
                                    @endif
                                </label>
                                <span class="badge border font-weight-normal"></span>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                    </form>
                </div>
                <!-- Price End -->
            </div>

            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    @foreach( $products as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4 d-flex flex-column" style="height: 400px;">
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
                                        <h5>{{number_format($item->price, 0, '', ',')}}đ</h5>
                                        @if ($item->sale >0)
                                            <h6 class="text-muted ml-2"><del>{{ number_format($item->price + ($item->price * $item->sale / 100), 0, '', ',') }}đ</del></h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection
