@extends('client.layouts.app')
@section('title','Tin tức -')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('client.home') }}">Trang chủ</a>
                    <span class="breadcrumb-item active">Tin tức</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
     <!-- Blog Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <a href="{{ route('blog.detail') }}"><img class="img-fluid w-100" src="{{ asset('client/img/aomu.jpg') }}" alt=""></a>
                    </div>
                    <div class="mt-2 text-center"><span class="h5 text-decoration-none justify-content-center">Mu ra mắt áo đấu</span></div>
                    <div class="text-center py-4">
                        <a class=" mx-2 h10 text-decoration-none text-truncate float-right" href="{{ route('blog.detail') }}">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
