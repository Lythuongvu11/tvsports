@extends('client.layouts.app')
@section('title', 'Đăng nhập -')
@section('content')
    <div class="container-fluid pt-5">
        <h2 class="text-center mb-5">Đăng nhập</h2>
        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @elseif(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row px-xl-12 justify-content-center">
            <form method="POST" action="{{ route('user.login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="row mb-4">
                    <div class="col d-flex justify-content-center">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="remember"/>
                            <label class="form-check-label" for="remember"> Nhớ tài khoản</label>
                        </div>
                    </div>

                    <div class="col">
                        <a href="{{route('user.forgotForm')}}">Quên mật khẩu?</a>
                    </div>
                </div>
                <div class="col d-flex justify-content-center mb-3">
                    <a href="{{route('user.register')}}">Chưa có tài khoản? Đăng ký ngay</a>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </form>
        </div>
    </div>
@endsection
