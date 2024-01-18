@extends('client.layouts.app')
@section('title', 'Chỉnh sửa tài khoản -')
@section('content')
    <div class="container mt-4">
        <h2>Chỉnh sửa thông tin tài khoản</h2>

        <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-5 input-group-static mb-3">
                    <label>Ảnh đại diện</label>
                    <input type="file" id="image-input" name="avatar" class="form-control-file">
                </div>
                <div class="col-5">
                    <img src="{{ asset($user->avatar) }}" class="w-50" id="show-image" alt="">
                </div>
            </div>
            <div class="form-group">
                <label for="name">Họ và tên:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="birthday">Ngày sinh:</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday) }}">
                @error('birthday')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                @error('address')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label name="group" class="ms-0">Giới tính</label>
                <select name="gender" class="form-control" value={{ $user->gender }}>
                    <option value="male">Nam</option>
                    <option value="fe-male">Nữ</option>

                </select>

                @error('gender')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" value="{{ old('password') ?? $user->password }}" class="form-control" id="password" name="password">
                @error('password')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function(){
            // Khi người dùng chọn một ảnh mới
            $('#image-input').change(function(){
                // Đọc đường dẫn của ảnh mới
                var imagePath = URL.createObjectURL(this.files[0]);

                // Hiển thị ảnh mới trong thẻ <img>
                $('#show-image').attr('src', imagePath);
            });
        });
    </script>
@endsection
