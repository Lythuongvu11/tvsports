@extends('client.layouts.app')
@section('title','Đơn hàng -')
@section('content')
    <div class="container-fluid pt-5">
        @if (session('success'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif


        <div class="col">
            <div>
                <table class="table table-hover">
                    <tr>
                        <th>Trạng thái</th>
                        <th>Tổng</th>
                        <th>Phí vận chuyển</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Địa chỉ khách hàng</th>
                        <th>Ghi chú</th>
                        <th>Hình thức thanh toán</th>
                        <th></th>
                    </tr>

                    @foreach ($orders as $item)
                        <tr>

                            <td>{{ $item->status }}</td>
                            <td>{{number_format($item->total, 0, '', ',')}}đ</td>

                            <td>{{number_format($item->ship, 0, '', ',')}}đ</td>
                            <td>{{ $item->customer_name }}</td>
                            <td>{{ $item->customer_email }}</td>

                            <td>{{ $item->customer_address }}</td>
                            <td>{{ $item->note }}</td>
                            <td>{{ $item->payment }}</td>
                            <td>
                                @if ($item->status == 'Đang chờ xử lý')
                                    <form action="{{ route('client.orders.cancel', $item->id) }}"
                                          id="form-cancel{{ $item->id }}" method="POST">
                                        @csrf
                                        <button class="btn btn-cancel btn-danger" data-id="{{ $item->id }}">Hủy</button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $orders->links() }}
            </div>
        </div>

    </div>

@endsection


