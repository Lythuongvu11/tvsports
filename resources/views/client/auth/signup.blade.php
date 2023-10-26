@extends('client.layouts.app')
@section('title','Đăng kí -')
@section('content')
    <div class="container pt-5">
        <h2 class="text-center mb-5">Đăng kí tài khoản</h2>
        <div class="row px-xl-12 justify-content-center">
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input type="text" class="form-control" id="name" aria-describedby="nameHelp"
                               placeholder="họ và tên">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                               placeholder="nhập email">
                    </div>
                    <div class="form-group ">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" aria-describedby="phoneHelp"
                               placeholder="số điện thoại">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" placeholder="nhập mật khẩu">
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="password-confirm"
                               placeholder="Nhập lại mật khẩu">
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng kí</button>
                </form>
            </div>
        </div>
    </div>
@endsection

