@extends('client.layouts.app')
@section('title','Thanh toán -')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Trang chủ</a>
                    <span class="breadcrumb-item active">Thanh toán</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <form class="row px-xl-5" method="POST" action="{{route('client.checkout.process')}}">
            @csrf
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin người nhận</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ và tên</label>
                            <input class="form-control" type="text" value="{{ old('customer_name') }}" name="customer_name" placeholder="họ và tên">
                            @error('customer_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" type="text" value="{{ old('customer_phone') }}" name="customer_phone" placeholder="số điện thoại">
                            @error('customer_phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" value="{{ old('customer_email') }}" name="customer_email" placeholder="email">
                            @error('customer_email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ</label>
                            <input class="form-control" type="text" value="{{ old('customer_address') }}" name="customer_address" placeholder="địa chỉ chi tiết">
                            @error('customer_address')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Note</label>
                            <input class="form-control" type="text" value="{{ old('note') }}" name="note" placeholder="ghi chú">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin hóa đơn</span></h5>
                <div class="bg-light p-30 mb-5">
                    @foreach ($cart->products as $item)
                        <div class="d-flex justify-content-between">
                            <p>{{ $item['product_quantity'] }} x {{ $item['product_name'] }} - {{$item['product_size']}}</p>
                            <p>{{ number_format($item['product_price'] * $item['product_quantity'], 0, '', ',') }}đ</p>
                        </div>
                    @endforeach
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tạm tính</h6>
                            <h6>{{number_format($totalPrice, 0, '', ',')}}đ</h6>
                        </div>
                        @if (session('discount_amount_price'))
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Mã giảm giá </h6>
                                <h6 class="font-weight-medium coupon-div"
                                    data-price="{{ session('discount_amount_price') }}">
                                    {{  number_format(session('discount_amount_price'), 0, '', ',') }}đ</h6>
                            </div>
                        @endif
                        @if ($membershipDiscount > 0)
                            <div class="mb-3">
                                <h5 class="section-title position-relative text-uppercase mb-3">
                                    <span class="bg-secondary pr-3">Ưu đãi thành viên</span>
                                </h5>
                                <div class="bg-light p-3">
                                    <p>Bạn được giảm giá {{ number_format($membershipDiscount, 0, '', ',') }}đ vì là thành viên cấp độ {{ $userMembershipLevel }}.</p>
                                </div>
                            </div>
                        @endif
                        @if($specialBirthdayDiscount > 0)
                            <div class="mb-3">
                                <h5 class="section-title position-relative text-uppercase mb-3">
                                    <span class="bg-secondary pr-3">Ưu đãi sinh nhật</span>
                                </h5>
                                <div class="bg-light p-3">
                                    <p>Bạn được giảm giá {{ number_format($specialBirthdayDiscount, 0, '', ',') }}đ vì là sinh nhật của bạn.</p>
                                </div>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí vận chuyển</h6>
                            <h6 class="font-weight-medium">{{number_format(30000, 0, '', ',')}}đ</h6>
                            <input type="hidden" name="ship" value="30000">
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Tổng</h5>
                            <h5><span>{{number_format($totalAmount, 0, '', ',')}}đ</span></h5>
                            <input type="hidden" name="totalAmount" value="{{$totalAmount}}">
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Hình thức thanh toán</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-check mb-3">
                            <input type="radio" class="form-check-input" name="payment" id="directcheck" value="cash_on_delivery">
                            <label class="form-check-label" for="directcheck">Thanh toán khi nhận hàng</label>
                        </div>
                        <div class="form-check mb-4">
                            <input type="radio" class="form-check-input" name="payment" id="banktransfer" value="bank_transfer">
                            <label class="form-check-label" for="banktransfer">Thanh toán bằng VNPay</label>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold py-3">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->

@endsection

