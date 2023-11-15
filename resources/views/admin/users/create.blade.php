@extends('admin.layouts.app')
@section('title', 'Create User')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Tạo mới người dùng</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <div>
            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
               <div class="row">
                   <div class="col-5 input-group-static mb-3">
                       <label>Avatar</label>
                       <input type="file" id="image-input" name="avatar" class="form-control-file">
                       @error('avatar')
                       <span class="text-danger"> {{ $message }}</span>
                       @enderror
                   </div>
                   <div class="col-5">
                       <img src="" class="w-50" id="show-image" alt="">
                   </div>
               </div>
                <div class="mb-3">
                    <label>Tên</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                    @error('name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="text" value="{{ old('email') }}" name="email" class="form-control">
                    @error('email')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" value="{{ old('phone') }}" name="phone" class="form-control">
                    @error('phone')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label name="group" class="ms-0">Giới tính</label>
                    <select name="gender" class="form-control">
                        <option value="male">Nam</option>
                        <option value="fe-male">Nữ</option>

                    </select>

                    @error('gender')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Địa chỉ</label>
                    <textarea name="address" class="form-control">{{ old('address') }} </textarea>
                    @error('address')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Vai trò</label>
                    <div class="row">
                        @foreach ($roles as $groupName => $role)
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        @foreach ($role as $item)
                                            <div class="form-check">
                                                <input class="form-check-input" name="role_ids[]" type="checkbox" value="{{ $item->id }}" id="role_{{ $item->id }}">
                                                <label class="form-check-label" for="role_{{ $item->id }}">
                                                    {{ $item->display_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Lưu</button>
            </form>
        </div>
    </div>
@endsection


