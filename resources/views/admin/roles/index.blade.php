@extends('admin.layouts.app')
@section('title', 'Quản lý vai trò')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><h1>Quản lý vai trò</h1></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        @if (session('message'))
            <h1 class="text-danger">{{ session('message') }}</h1>
        @endif
        <div class="mt-3 mx-3 mb-3">
            <a href="{{ route('roles.create')}}" class="btn btn-link">Tạo mới vai trò</a>
        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Tên vai trò</th>
                    <th>Tên hiển thị</th>
                    <th>Chỉnh sửa</th>
                </tr>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->display_name}}</td>
                        <td>
                            <a href="{{route('roles.edit',$role->id)}}" class="btn btn-warning">Sửa</a>
                            <form id="form-delete{{$role->id}}" action="{{ route('roles.destroy', $role->id) }}"
                                  method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" data-id={{ $role->id }} onclick="deleteRole({{ $role->id }})">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$roles->links()}}
        </div>

    </div>
    <script>
        function deleteRole(roleId) {
            if (confirm("Bạn có chắc chắn muốn xóa vai trò này?")) {
                document.getElementById('form-delete' + roleId).submit();
            }
        }
    </script>
@endsection

