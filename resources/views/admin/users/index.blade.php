@extends('admin.layouts.app')
@section('title','Quản lý người dùng')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><h1>Quản lý người dùng</h1></a>
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
                        <a href="{{route('users.create')}}" class="btn btn-link">Tạo mới người dùng</a>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Ảnh đại diện</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Chỉnh sửa</th>
                            </tr>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td style="width: 150px; height: 150px;">
                                        <img class="img-fluid" src="{{ asset($item->avatar) }}" alt="Avatar">
                                    </td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>
                                        <a href="{{route('users.edit', $item->id)}}" class="btn btn-warning">Sửa</a>
                                        <form id="form-delete{{$item->id}}" action="{{ route('users.destroy', $item->id) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-id={{ $item->id }} onclick="deleteUser({{ $item->id }})">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{$users->links()}}
                    </div>

                </div>
            </table>
        </div>
    </div>
    <script>
        function deleteUser(userId) {
            if (confirm("Bạn có chắc chắn muốn xóa người dùng này?")) {
                document.getElementById('form-delete' + userId).submit();
            }
        }
    </script>
@endsection
