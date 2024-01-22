@extends('client.layouts.app')
@section('title', 'Sản phẩm -')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{route('client.home')}}">Trang chủ</a>
                    <span class="breadcrumb-item active">Sản phẩm chi tiết</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
       <form action="{{ route('client.carts.add') }}" method="post" >
           @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
           <div class="row px-xl-5">
               <div class="col-lg-6 mb-30">
                   <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                       <div class="swiper-wrapper">
                           @foreach($carouselData as $item)
                               <div class="swiper-slide">
                                   <img class="img-fluid" src="{{ $item['image'] }}" />
                               </div>
                           @endforeach
                       </div>
                       <div class="swiper-button-next"></div>
                       <div class="swiper-button-prev"></div>
                   </div>
                   <div thumbsSlider="" class="swiper mySwiper">
                       <div class="swiper-wrapper">
                           @foreach($carouselData as $item)
                               <div class="swiper-slide">
                                   <img class="img-fluid" src="{{ $item['image'] }}" />
                               </div>
                           @endforeach
                       </div>
                   </div>
               </div>

               <div class="col-lg-6 h-auto mb-30">
                   @if( session('message'))
                       <h2 class="text-center text-danger">{{ session('message') }}</h2>
                   @else(session('success'))
                       <h2 class="text-center text-success">{{ session('success') }}</h2>
                   @endif
                   <div class="h-100 bg-light p-30">
                       <h3>{{ $product->name}}</h3>
                       <div class="mb-4">
                           <h3 class="font-weight-semi-bold d-inline mr-2">{{number_format($product->price, 0, '', ',')}}đ</h3>
                           @if ($product->sale >0)
                               <h5 class="text-muted d-inline"><del>{{ number_format($product->price + ($product->price * $product->sale / 100), 0, '', ',') }}đ</del></h5>
                               @endif
                       </div>
                       <a class="mb-3" onclick="toggleImage()">Hướng dẫn chọn size giày</a>
                       <div id="sizeChart" style="display:none;">
                           <img class="w-100" src="{{ asset('client/img/size_giay.webp') }}" alt="Size Chart">
                       </div>

                       <div class="d-flex mb-3">
                           <strong class="text-dark mr-3">Size:</strong>
                           <form>
                               @foreach(explode(',', $product->details->size) as $size)
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="product_size" value="{{ $size}}" id="size{{$size}}">
                                       <label class="form-check-label" for="size{{$size}}">{{$size}}</label>
                                   </div>
                               @endforeach
                           </form>
                       </div>
                       <div class="d-flex mb-3">
                           <strong class="text-dark mr-3">Màu sắc:</strong>
                               @foreach(explode(',', $product->details->color) as $color)
                                   <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="product_color" id="color{{$color}}"  value="{{$color}}">
                                       <label class="form-check-label" for="color{{$color}}">{{$color}}</label>
                                   </div>
                               @endforeach
                       </div>
                       <div class="d-flex align-items-center mb-4 pt-2">
                           <div class="input-group quantity mr-3" style="width: 130px;">
                               <div class="input-group-btn">
                                   <button class="btn btn-primary btn-minus" name="product_quantity_down">
                                       <i class="fa fa-minus"></i>
                                   </button>
                               </div>
                               <input type="text" class="form-control bg-secondary border-0 text-center" name="product_quantity" value="1">
                               <div class="input-group-btn">
                                   <button class="btn btn-primary btn-plus" name="product_quantity_up">
                                       <i class="fa fa-plus"></i>
                                   </button>
                               </div>
                           </div>
                           <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ hàng </button>
                       </div>
                       <div class="d-flex pt-2">
                           <strong class="text-dark mr-2">Share on:</strong>
                           <div class="d-inline-flex">
                               <a class="text-dark px-2" href="">
                                   <i class="fab fa-facebook-f"></i>
                               </a>
                               <a class="text-dark px-2" href="">
                                   <i class="fab fa-twitter"></i>
                               </a>
                               <a class="text-dark px-2" href="">
                                   <i class="fab fa-linkedin-in"></i>
                               </a>
                               <a class="text-dark px-2" href="">
                                   <i class="fab fa-pinterest"></i>
                               </a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </form>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Mô tả</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Đánh giá</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Mô tả sản phẩm</h4>
                            <p>{{$product->description}}</p>
                        </div>

                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">{{ $reviews->count() }} đánh giá</h4>
                                    @foreach($reviews as $review)
                                        <div class="media mb-4">
                                            <div class="media-body">
                                                <h6>{{ $review->user_name }}<small> - <i>{{ $review->created_at->format('m d Y') }}</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <form method="post" action="{{ route('client.product.review',$product->id) }}">
                                        @csrf
                                        <div class="">
                                            <h4 class="mb-4">Để lại đánh giá</h4>
                                            <div class="d-flex my-3">
                                                <p class="mb-0 mr-2">Đánh giá của bạn * :</p>
                                                <div class="text-primary" id="star-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="far fa-star" data-rating="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            @error('rating')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <input type="hidden" name="rating" id="rating-input" value="0">
                                            <div class="form-group">
                                                <label for="message">Nhận xét của bạn *</label>
                                                <textarea id="message" name="comment" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                            @error('comment')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group mb-0">
                                                <input type="submit" value="Đánh giá" class="btn btn-primary px-3">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm tương tự</span></h2>
        <div class="row px-xl-5">
            @foreach( $similarProducts as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4 d-flex flex-column" style="height: 500px;">
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
        </div>
    </div>
    <!-- Products End -->

@endsection
