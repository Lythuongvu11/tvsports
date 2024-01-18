@extends('admin.layouts.app')
@section('title', 'Quản lý đơn hàng')
@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card">

        <h1>
            Đơn hàng
        </h1>
        <div class="container-fluid pt-5">

            <div class="col card">
                <div>
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>Trạng thái</th>
                            <th>Phí ship</th>
                            <th>Tổng</th>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <th>Địa chỉ khách hàng</th>
                            <th>Ghi chú</th>
                            <th>Hình thức thanh toán</th>
                            <th>Chi tiết</th>
                        </tr>

                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <div class="input-group input-group-static mb-4">
                                        <select name="status" class="form-control select-status"
                                                data-action="{{ route('admin.orders.update_status', $item->id) }}">
                                            @foreach (config('order.status') as $status)
                                                <option value="{{ $status }}"
                                                    {{ $status == $item->status ? 'selected' : '' }}>{{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>{{number_format($item->ship, 0, '', ',')}}đ</td>
                                <td>{{number_format($item->total, 0, '', ',')}}đ</td>

                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->customer_email }}</td>

                                <td>{{ $item->customer_address }}</td>
                                <td>{{ $item->note }}</td>
                                <td>{{ $item->payment }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $item->id) }}" class="btn btn-primary">
                                        Xem chi tiết
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection


