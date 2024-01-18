@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa sản phẩm')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Chỉnh sửa sản phẩm</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <div>
            <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-5 input-group-static mb-3">
                        <label>Image</label>
                        <input type="file" id="image-input" name="image" class="form-control-file">
                        @error('image')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="{{ asset($product->image) }}" class="w-50" id="show-image" alt="">
                    </div>
                </div>
                <div class="mb-3">
                    <label>Ảnh phụ</label>
                    <div class="row">
                        <div class="col-5">
                            <div id="image-container">
                                <div class="input-group mb-3">
                                    <input type="file" name="image_products[]" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addImageButton">+</button>
                                    </div>
                                </div>
                                @error('image_products.*.image')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Tên sản phẩm</label>
                    <input type="text" value="{{ old('name') ?? $product->name }}" name="name" class="form-control">
                    @error('name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Giá</label>
                    <input type="number" step="0.1" value="{{ old('price') ?? $product->price }}" name="price" class="form-control">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Giảm giá</label>
                    <input type="number" value="{{ old('sale') ?? $product->sale }}" name="sale" class="form-control">
                    @error('sale')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror

                </div>
                <div class="input-group input-group-static mb-3">
                    <label>Mô tả</label>
                    <div class="row w-100 h-100">
                        <textarea name="description" id="description" class="form-control" cols="4" rows="5"
                                  style="width: 100%">{{ old('description') ?? $product->description }} </textarea>
                    </div>
                    @error('description')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="size">Size:</label>
                    <input type="text" name="size" id="size" class="form-control" value="{{ $product->details->size ?? '' }}" >
                </div>
                <div class="mb-3">
                    <label for="color">Color:</label>
                    <input type="text" name="color" id="color" class="form-control" value="{{ $product->details->color ?? '' }}">
                </div>
                <div class="mb-3">
                    <label for="quantity">Số lượng:</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" value="{{ $product->details->quantity ?? '' }}">
                </div>
                @include('admin.categories.form')

                <div class="mb-3">
                    <label for="category_id">Danh mục</label>
                    <select name="category_ids[]" class="form-control" multiple style="height: 300px">
                        <option value="">Chọn danh mục</option>
                        @foreach($parentCategories as $category)
                            @php renderCategories([$category], $product->categories->pluck('id')->toArray()) @endphp
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="hot" name="hot" {{ $product->hot ? 'checked' : '' }}>
                    <label class="form-check-label" for="hot">Sản phẩm HOT</label>
                </div>
                <button type="submit" class="btn btn-submit btn-primary">Lưu</button>
            </form>
        </div>
    </div>
@endsection


