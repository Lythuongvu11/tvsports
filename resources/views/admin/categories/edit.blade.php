@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa danh mục')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Chỉnh sửa danh mục</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <form action="{{ route('categories.update',$category->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name">Tên danh mục</label>
                <input type="text" value="{{ old('name') ?? $category->name}}" name="name" class="form-control" id="name">
                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            @include('admin.categories.form')


            <div class="mb-3">
                <label name="group" class="ms-0">Danh mục cha</label>
                <select name="parent_id" class="form-control">
                    <option value=""> Chọn danh mục cha</option>
                    @foreach($parentCategories as $item)
                        @php renderCategories([$item], [$category->parent_id]) @endphp
                    @endforeach
                </select>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-link">Lưu</button>
            </div>
        </form>
    </div>
@endsection
