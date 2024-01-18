@extends('client.layouts.app')
@section('title','Thành công -')
@section('content')
    <div class="container text-center mt-3">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle bg-success" style="width: 40px; height: 40px; margin-left: 527px;">
                            <i class="fa fa-check" style="color: #ffffff; font-size: 25px;"></i>
                        </div>
                        <h3 class="panel-title">Đặt hàng thành công!</h3>
                    </div>
                    <div class="panel-body">
                        <p>Đơn hàng của bạn đã được đặt thành công.</p>
                        <p>Bạn có thể quay lại trang chủ bằng cách nhấn vào bên dưới.</p>
                        <a href="{{ route('client.home') }}" class="btn btn-primary">Quay về trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
