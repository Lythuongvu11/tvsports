@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa mã giảm giá')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Chỉnh sửa mã giảm giá</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <form action="{{ route('coupons.update',$coupon->id) }}" method="post">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name">Tên mã giảm giá</label>
                <input type="text" value="{{ old('name') ?? $coupon->name }}" name="name" class="form-control" id="name">
                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label>Giá trị</label>
                <input type="number" value="{{ old('value') ?? $coupon->value}}" name="value" class="form-control">

                @error('value')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label name="group" class="ms-0">Thể loại</label>
                <select name="type" class="form-control">
                    <option> Chọn thể loại </option>
                    <option value="money" {{ (old('type') ?? $coupon->type) == 'money' ? 'selected' : '' }}> Money </option>
                </select>
            </div>
            @error('type')
            <span class="text-danger"> {{ $message }}</span>
            @enderror

            <div class="mb-3">
                <label>Ngày hết hạn</label>
                <input type="date" value="{{ old('expery_date') ?? $coupon->expery_date }}" name="expery_date" class="form-control">

                @error('expery_date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_id">Danh mục</label>
                <ul>
                    @foreach($categories as $category)
                        @include('admin.coupons.category-checkbox', [
                            'category' => $category,
                            'checked' => in_array($category->id, $selectedCategories),
                        ])
                    @endforeach
                </ul>
            </div>


            <div class="mt-5">
                <button type="submit" class="btn btn-link">Lưu</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categoryCheckboxes = document.querySelectorAll('.category-checkbox');

            categoryCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    var isChecked = this.checked;
                    var childCheckboxes = this.closest('li').querySelectorAll('.category-checkbox');

                    if (childCheckboxes.length > 0) {
                        childCheckboxes.forEach(function (childCheckbox) {
                            childCheckbox.checked = isChecked;
                        });
                    }
                });
            });
        });
    </script>
@endsection
