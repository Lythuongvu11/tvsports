@extends('admin.layouts.app')
@section('title','Quản lý sản phẩm')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><h1>Quản lý sản phẩm</h1></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <div class="card">
                    @if (session('message'))
                        <h1 class="text-primary">{{ session('message') }}</h1>
                    @endif
                    <div class="mt-3 mx-3 mb-3">
                        <a href="{{route('products.create')}}" class="btn btn-link">Tạo mới sản phẩm</a>
                    </div>
                    <form class="form-inline" action="{{ route('products.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="w-25" name="search" value="{{ $search }}" placeholder="Tìm kiếm sản phẩm">
                            <div class="input">
                                <button class="mx-1 btn btn-outline-secondary" type="submit" id="button-addon2">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>Chỉnh sửa</th>
                            </tr>
                            @foreach($products as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td style="width: 150px; height: 150px;">
                                        @if($item->image)
                                            <img src="{{ asset($item->image )}}" alt="{{ $item->name }}" width="100%" height="100%">
                                        @else
                                            <p>No Image</p>
                                        @endif
                                    </td>

                                    <td>{{$item->name}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->sale}}%</td>
                                    <td>
                                        <a href="{{route('products.edit', $item->id)}}" class="btn btn-warning">Sửa</a>
                                        <a href="{{route('products.show', $item->id)}}" class="btn btn-info">Xem</a>
                                        <form id="form-delete{{$item->id}}"
                                              action="{{ route('products.destroy', $item->id) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger"
                                                    data-id={{ $item->id }} onclick="deleteProducts({{ $item->id }})">
                                                Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{$products->links()}}
                    </div>

                </div>
            </table>
        </div>
    </div>
    <script>
        function deleteProducts(productId) {
            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                document.getElementById('form-delete' + productId).submit();
            }
        }
    </script>
@endsection
