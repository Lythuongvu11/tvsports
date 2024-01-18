@extends('admin.layouts.app')
@section('title', 'Xem sản phẩm')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Xem sản phẩm</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset($product->image) }}" class="card-img-top" alt="Product Image">
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if ($product->hot)
                        <p class="text-danger fw-bold">Sản phẩm HOT</p>
                    @endif
                    <h5 class="h2">{{ $product->name }}</h5>
                    <p class="card-text"><strong>Giá:</strong> {{ $product->price }}</p>
                    <p class="card-text"><strong>Giảm giá:</strong> {{ $product->sale }}%</p>
                    <p class="card-text"><strong>Mô tả:</strong> {{ $product->description }}</p>
                    <p class="card-text"><strong>Size:</strong> {{ $product->details->size }}</p>
                    <p class="card-text"><strong>Màu sắc:</strong> {{ $product->details->color }}</p>
                    <p class="card-text"><strong>Số lượng:</strong> {{ $product->details->quantity }}</p>

                    <div class="mb-3">
                        <label class="fw-bold">Danh mục:</label>
                        <ul class="list-group">
                            @foreach ($product->categories as $category)
                                <li class="list-group-item">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
