@extends('admin.layouts.app')
@section('title', 'Bảng điều khiển')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><b>Bảng điều khiển</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Người dùng</p>
                        <h4 class="mb-0">{{ $userCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">

            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Sản phẩm</p>
                        <h4 class="mb-0">{{ $productCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">

            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Danh mục</p>
                        <h4 class="mb-0">{{ $categoryCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">

            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Mã giảm giá</p>
                        <h4 class="mb-0">{{ $couponCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
            </div>
        </div>
    </div>
    <div id="chart">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
    <button id="btnMonthly" class="btn btn-primary">Thống kê theo tháng</button>
    <button id="btnDaily" class="btn btn-success">Thống kê theo ngày</button>
    <div class="row mb-3">
        <div class="col-12 col-lg-6">
            <div class="card card-table">
                <div class="card-header">
                    <div class="title">Đơn hàng gần đây</div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th style="width:40%;">Khách hàng</th>
                            <th class="number">Giá</th>
                            <th style="width:20%;">Ngày tạo</th>
                            <th style="width:20%;">Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody class="no-border-x">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->customer_name }}</td>
                                <td class="number">{{number_format($order->total, 0, '', ',')}}đ</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="text-{{ $order->status == 'Đang chờ xử lý' ? 'warning' :
                                                ($order->status == 'Chấp nhận' ? 'primary' :
                                                ($order->status == 'Giao hàng' ? 'info' :
                                                ($order->status == 'Thành công' ? 'success' : 'danger'))) }}">
                                    {{ $order->status }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-table">
                <div class="card-header">
                    <div class="title">Khách hàng mới</div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width:37%;">Tên khách hàng</th>
                            <th style="width:36%;">Số sản phẩm</th>
                            <th>Ngày tạo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newCustomers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->orders->flatMap->productOrders->sum('product_quantity') }}</td>
                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biến global cho biểu đồ
        var chart;

        // Hàm để tạo và cập nhật biểu đồ doanh thu
        function createOrUpdateChart(labels, data, backgroundColor, borderColor) {
            // Nếu biểu đồ chưa được tạo, thì tạo mới
            if (!chart) {
                var ctx = document.getElementById('myChart').getContext('2d');
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh thu',
                            data: data,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                // Nếu biểu đồ đã tồn tại, cập nhật dữ liệu
                chart.data.labels = labels;
                chart.data.datasets[0].data = data;
                chart.update();
            }
        }

        // Mặc định hiển thị thống kê doanh thu theo ngày
        handleDailyChart();

        // Thêm sự kiện cho nút thống kê theo tháng
        document.getElementById('btnMonthly').addEventListener('click', function() {
            // Gọi hàm để thực hiện thống kê theo tháng
            handleMonthlyChart();
        });

        // Thêm sự kiện cho nút thống kê theo ngày
        document.getElementById('btnDaily').addEventListener('click', function() {
            // Gọi hàm để thực hiện thống kê theo ngày
            handleDailyChart();
        });

        // Hàm để thực hiện thống kê theo tháng
        function handleMonthlyChart() {
            // Gọi hàm từ server để lấy dữ liệu thống kê theo tháng (có thể sử dụng Ajax)
            var monthlyData = {!! json_encode($monthlyData) !!};

            // Cập nhật biểu đồ
            createOrUpdateChart(monthlyData.map(item => item.date), monthlyData.map(item => item.revenue), 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
        }

        // Hàm để thực hiện thống kê theo ngày
        function handleDailyChart() {
            // Gọi hàm từ server để lấy dữ liệu thống kê theo ngày (có thể sử dụng Ajax)
            var dailyData = {!! json_encode($dailyData) !!};

            // Cập nhật biểu đồ
            createOrUpdateChart(dailyData.map(item => item.date), dailyData.map(item => item.revenue), 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 1)');
        }
    </script>

@endsection
