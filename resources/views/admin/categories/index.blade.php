@extends('admin.layouts.app')
@section('title','Quản lý danh mục')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"><h1>Quản lý danh mục</h1></a>
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
                        <a href="{{route('categories.create')}}" class="btn btn-link">Tạo mới danh mục</a>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th>Chỉnh sửa</th>
                            </tr>
                            @foreach($categories as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->parent_name}}</td>
                                    <td>
                                        <a href="{{route('categories.edit', $item->id)}}" class="btn btn-warning">Sửa</a>
                                        <form id="form-delete{{$item->id}}" action="{{ route('categories.destroy', $item->id) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger" data-id={{ $item->id }} onclick="deleteCategories({{ $item->id }})">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{$categories->links()}}
                    </div>

                </div>
            </table>
        </div>
    </div>
    <script>
        function deleteCategories(categoriesId) {
            if (confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
                document.getElementById('form-delete' + categoriesId).submit();
            }
        }
    </script>
@endsection
