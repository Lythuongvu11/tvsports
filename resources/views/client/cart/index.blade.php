@extends('client.layouts.app')
@section('title','Giỏ hàng -')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('client.home') }}">Trang chủ</a>
                    <span class="breadcrumb-item active">Giỏ hàng</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Xóa</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                    @foreach($cartProducts as $item)
                        <tr>
                            <td class="align-middle">
                                <img src="{{ $item['product_img'] }}" alt="Product Image" style="width: 50px;">
                            </td>
                            <td class="align-middle">{{ $item['product_name'] }} - {{ $item['product_size'] }} - {{ $item['product_color'] }}</td>
                            <td class="align-middle">{{ number_format($item['product_price'], 0, '', ',') }}đ</td>
                            <td class="align-middle">
                                {{$item['product_quantity']}}
{{--                                <div class="input-group quantity mx-auto" style="width: 100px;">--}}
{{--                                    <div class="input-group-btn">--}}
{{--                                        <button class="btn btn-sm btn-primary btn-minus btn-update-quantity"--}}
{{--                                                data-action="minus"--}}
{{--                                                data-id="">--}}
{{--                                            <i class="fa fa-minus"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                   --}}
{{--                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center"  value="{{ $item['product_quantity'] }}">--}}
{{--                                    <div class="input-group-btn">--}}
{{--                                        <button class="btn btn-sm btn-primary btn-plus btn-update-quantity"--}}
{{--                                                data-action="plus"--}}
{{--                                                data-id="">--}}
{{--                                            <i class="fa fa-plus"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </td>
                            <td class="align-middle">{{ number_format($item['product_price'] * $item['product_quantity'], 0, '', ',')  }}đ</td>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-danger delete-product" data-product-id="{{ $item['product_id'] }}" onclick="deleteProduct({{ $item['product_id'] }}, 'Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                @if (session('message'))
                    <div class="row">
                        <h6 class="ml-3 mb-3 text-danger">{{ session('message') }}</h6>
                    </div>
                @else(session('success'))
                    <h2 class="text-center text-success">{{ session('success') }}</h2>
                @endif
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cộng giỏ hàng</span></h5>
                <form class="mb-5" method="POST" action="{{ route('client.carts.apply_coupon') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control p-4" value="{{ Session::get('coupon_code') }}"
                               name="coupon_code" placeholder="Mã giảm giá">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Áp dụng</button>
                        </div>
                    </div>
                </form>

                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tạm tính</h6>
                            <h6>{{number_format($totalPrice, 0, '', ',')}}đ</h6>
                        </div>
                        @if (session('discount_amount_price'))
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Mã giảm giá</h6>
                                <h6 class="font-weight-medium coupon-div"
                                    data-price="{{ session('discount_amount_price') }}">
                                    {{ number_format(session('discount_amount_price'), 0, '', ',') }}đ </h6>
                            </div>
                        @endif

                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Tổng</h5>
                            <h5>{{number_format($totalAmount, 0, '', ',')}}đ</h5>
                        </div>
                        <a href="{{ route('client.carts.checkout')}}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Đặt hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    <script>
        function deleteProduct(productId, confirmationMessage) {
            if (confirm(confirmationMessage)) {
                // Nếu người dùng xác nhận muốn xóa
                $.ajax({
                    url: '/cart/delete',
                    method: 'DELETE',
                    data: {
                        productId: productId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            // Xóa hàng thành công, có thể cập nhật giao diện người dùng tại đây
                            location.reload();
                        } else {
                            // Xóa hàng không thành công, xử lý theo nhu cầu của bạn
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endsection
