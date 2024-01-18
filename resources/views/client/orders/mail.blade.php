<div style="width: 600px;margin: 0 auto">
    <div style="text-align: center">
        <p>Cảm ơn bạn đã đặt hàng tại TVSports! Đây là xác nhận đơn hàng của bạn.</p>
        <p>Thông tin đơn hàng:</p>
        <p>Mã đơn hàng: {{ $order->id }}</p>
        <p>Tổng tiền: {{number_format($order->total, 0, '', ',')}}đ</p>
    </div>
</div>
