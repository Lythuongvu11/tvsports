@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa Banner')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Chỉnh sửa Banner</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <div>
            <form action="{{ route('banners.update',$banner->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-5 input-group-static mb-3">
                        <label>Image</label>
                        <input type="file" id="image-input" name="image" class="form-control-file">
                    </div>
                    @error('image')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                    <div class="col-5">
                        <img src="{{ asset($banner->image) }}" class="w-50" id="show-image" alt="">
                    </div>
                </div>
                <div class="mb-3">
                    <label>Tiêu đề</label>
                    <input type="text" value="{{ old('title') ?? $banner->title }}" name="title" class="form-control">
                    @error('title')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Mô tả</label>
                    <input type="text" value="{{ old('description') ?? $banner->description }}" name="description" class="form-control">
                    @error('description')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Link</label>
                    <input type="text" value="{{ old('link') ?? $banner->link }}" name="link" class="form-control">
                    @error('link')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control" value="{{$banner->status}}">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                    @error('status')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Lưu</button>
            </form>
        </div>
    </div>
@endsection


