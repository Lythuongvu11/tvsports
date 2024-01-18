@extends('admin.layouts.app')
@section('title', 'Chi tiết đơn hàng')
@section('content')

    <div class="card">
        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
        <div class="container-fluid pt-5">
            <!-- Hiển thị thông tin đơn hàng -->
            <div class="col card">
                <!-- Thêm mã HTML/CSS để hiển thị thông tin đơn hàng -->
                <!-- Ví dụ: -->
                <p>Trạng thái: {{ $order->status }}</p>
                <p>Ship: {{ number_format($order->ship, 0, '', ',') }}đ</p>
                <!-- ...Thêm các thông tin khác... -->
            </div>

            <!-- Hiển thị danh sách sản phẩm trong đơn hàng -->
            <div class="col card">
                <h2>Danh sách sản phẩm</h2>
                <table class="table table-hover">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Màu sắc</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                    </tr>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->product->name }}</td>
                            <td>{{ $product->product_size }}</td>
                            <td>{{ $product->product_color }}</td>
                            <td>{{ $product->product_quantity }}</td>
                            <td>{{ number_format($product->product_price, 0, '', ',') }}đ</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
