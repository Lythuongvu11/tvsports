@extends('client.layouts.app')
@section('title', 'Tài khoản -')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container mt-4">
        <h2>Thông tin tài khoản</h2>
        <p>Xin chào, {{ auth('user')->user()->name }}!</p>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin cá nhân</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Họ và tên:</strong> {{ auth('user')->user()->name }}</li>
                            <li class="list-group-item"><strong>Ngày sinh:</strong> {{ auth('user')->user()->birthday }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ auth('user')->user()->email }}</li>
                            <li class="list-group-item"><strong>Số điện thoại:</strong> {{ auth('user')->user()->phone }}</li>
                            <li class="list-group-item"><strong>Địa chỉ:</strong> {{ auth('user')->user()->address }}</li>
                            <li class="list-group-item"><strong>Giới tính:</strong> {{ auth('user')->user()->gender }}</li>
                            <li class="list-group-item"><strong>Cấp bậc thành viên:</strong> {{ $userPoints->membership_level ?? 'Chưa xác định' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ảnh đại diện</h5>
                        <div class="text-center">
                            <img src="{{ asset(auth('user')->user()->avatar) }}" alt="Ảnh đại diện" class="img-fluid rounded-circle" style="max-width: 150px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('user.profile.edit')}}" class="btn btn-primary">Chỉnh sửa tài khoản</a>

        <!-- Thêm các tùy chọn quản lý tài khoản khác nếu cần -->

    </div>
@endsection
