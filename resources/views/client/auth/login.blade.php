@extends('client.layouts.app')
@section('title','Đăng nhập -')
@section('content')
    <div class="container-fluid pt-5">
        <h2 class="text-center mb-5">Đăng nhập</h2>
        <div class="row px-xl-12 justify-content-center">
            <form>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                           placeholder="nhập email">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" placeholder="nhập mật khẩu">
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
                        <a href="#">Quên mật khẩu?</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </form>
        </div>
    </div>
@endsection
