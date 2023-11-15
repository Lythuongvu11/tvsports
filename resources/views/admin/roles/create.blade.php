@extends('admin.layouts.app')
@section('title', 'Tạo mới vai trò')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Tạo mới vai trò</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name">Tên vai trò</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name">
                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="display_name">Tên hiển thị</label>
                <input type="text" value="{{ old('display_name') }}" name="display_name" class="form-control" id="display_name">
                @error('display_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="group">Group</label>
                <select name="group" class="form-control" id="group">
                    <option value="hệ thống">hệ thống</option>
                    <option value="người dùng">người dùng</option>
                </select>
                @error('group')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Quyền</label>
                <div class="row">
                    @foreach ($permissions as $groupName => $permission)
                        <div class="col-5">
                            <h4>{{ $groupName }}</h4>

                            <div>
                                @foreach ($permission as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission_ids[]" type="checkbox"
                                               value="{{ $item->id }}">
                                        <label
                                            for="customCheck1">{{ $item->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-5">
                <button type="submit" class="btn btn-link">Lưu</button>
            </div>
        </form>
    </div>
@endsection
