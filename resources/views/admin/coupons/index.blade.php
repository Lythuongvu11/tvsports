@extends('admin.layouts.app')
@section('title','Quản lý mã giảm giá')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><h1>Quản lý mã giảm giá</h1></a>
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
                        <a href="{{route('coupons.create')}}" class="btn btn-link">Tạo mới mã giảm giá</a>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Tên mã giảm giá</th>
                                <th>Thể loại</th>
                                <th>Giá trị</th>
                                <th>Ngày hết hạn</th>
                                <th>Chỉnh sửa</th>
                            </tr>
                            @foreach($coupons as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{$item->value}}</td>
                                    <td>{{$item->expery_date}}</td>
                                    <td>
                                        <a href="{{route('coupons.edit',$item->id)}}" class="btn btn-warning">Sửa</a>
                                        <form id="form-delete{{$item->id}}" action="{{route('coupons.destroy',$item->id)}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-id={{ $item->id }} onclick="deleteCoupon({{ $item->id }})">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{$coupons->links()}}
                    </div>

                </div>
            </table>
        </div>
    </div>
    <script>
        function deleteCoupon(couponId) {
            if (confirm("Bạn có chắc chắn muốn xóa mã giảm giá này?")) {
                document.getElementById('form-delete' + couponId).submit();
            }
        }
    </script>
@endsection
