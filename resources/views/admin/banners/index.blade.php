@extends('admin.layouts.app')
@section('title','Quản lý Banner')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><h1>Quản lý Banner</h1></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <div class="card">
                    @if (session('message'))
                        <h1 class="text-success">{{ session('message') }}</h1>
                    @endif
                    <div class="mt-3 mx-3 mb-3">
                        <a href="{{route('banners.create')}}" class="btn btn-link">Tạo mới Banner</a>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Tiêu để</th>
                                <th>Mô tả</th>
                                <th>Link</th>
                                <th>Trạng thái</th>
                                <th>Chỉnh sửa</th>
                            </tr>
                            @foreach($banners as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td><img src="{{asset($item->image)}}" alt="" width="100px"></td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->link}}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="badge badge-success">Hiển thị</span>
                                        @else
                                            <span class="badge badge-danger">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('banners.edit', $item->id)}}" class="btn btn-warning">Sửa</a>
                                        <form id="form-delete{{$item->id}}" action="{{ route('banners.destroy', $item->id) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-id={{ $item->id }} onclick="deleteBanner({{ $item->id }})">Xóa</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        {{$banners->links()}}
                    </div>

                </div>
            </table>
        </div>
    </div>
    <script>
        function deleteBanner(bannerId) {
            if (confirm("Bạn có chắc chắn muốn xóa banner này?")) {
                document.getElementById('form-delete' + bannerId).submit();
            }
        }
    </script>
@endsection

