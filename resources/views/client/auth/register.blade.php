@extends('client.layouts.app')
@section('title','Đăng kí -')
@section('content')
    <div class="container pt-5">
        <h2 class="text-center mb-5">Đăng kí tài khoản</h2>
        <div class="row px-xl-12 justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('user.register') }}" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group">
                        <label for="avatar">Ảnh đại diện</label>
                        <input type="file" class="form-control-file" id="avatar" name="avatar">
                        @error('avatar')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input type="text" class="form-control" name="name" aria-describedby="nameHelp"
                               placeholder="Nhập họ và tên">
                        @error('name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh</label>
                        <input type="date" class="form-control" name="birthday" aria-describedby="birthdayHelp"
                               placeholder="Nhập ngày sinh">
                        @error('birthday')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp"
                               placeholder="Nhập email">
                        @error('email')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" class="form-control" name="phone" aria-describedby="phoneHelp"
                               placeholder="Nhập số điện thoại">
                        @error('phone')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ">
                        @error('address')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="male">Nam</option>
                            <option value="female">Nữ</option>
                            <option value="other">Khác</option>
                        </select>
                        @error('gender')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
                        @error('password')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" name="password-confirm"
                               placeholder="Nhập lại mật khẩu">
                        @error('password-confirm')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng kí</button>
                </form>
            </div>
        </div>
    </div>
@endsection

