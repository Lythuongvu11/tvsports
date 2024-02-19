<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentRequest($orderId)
    {
        // Lấy thông tin đơn hàng
        $order = Order::findOrFail($orderId);

        // Tạo URL thanh toán VNPay
        $vnp_Url = $this->createVnpayUrl($order); // Hàm tạo URL VNPay
        // Chuyển hướng đến URL thanh toán VNPay
        return redirect()->away($vnp_Url);
    }

    public function createVnpayUrl($order)
    {

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.payment.return'); // Đường dẫn callback VNPay
        $vnp_TmnCode = "O0HC4T4X"; // Mã website tại VNPAY
        $vnp_HashSecret = "PYAQLDZMTJAHRAQBCNKQEWNGLIBKHNRV"; // Chuỗi bí mật

        $vnp_TxnRef = $order->id; // Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "TVSports";
        $vnp_Amount = $order->total * 100; // Tổng giá trị đơn hàng (đã tính phí vận chuyển và giảm giá nếu có)
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB"; // Ngân hàng thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if ($vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }
    public function vnpayReturn(Request $request)
    {
        // Kiểm tra xem callback từ VNPay có hợp lệ hay không (thông qua xác thực mã xác minh)
        $secureHash = $request->input('vnp_SecureHash');
        $vnp_HashSecret = "PYAQLDZMTJAHRAQBCNKQEWNGLIBKHNRV"; // Chuỗi bí mật

        $data = $request->except('vnp_SecureHash');
        ksort($data);
        $query = http_build_query($data);

        $computedSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);

        if ($computedSecureHash === $secureHash) {
            // Mã xác minh hợp lệ, xử lý thanh toán thành công

            // Lấy thông tin đơn hàng
            $orderID = $request->input('vnp_TxnRef');
            $order = Order::findOrFail($orderID);

            // Kiểm tra trạng thái đơn hàng để tránh xử lý trạng thái trùng lặp
            if ($order->status != 'Chấp nhận') {
                // Cập nhật trạng thái đơn hàng thành completed
                $order->status = 'Chấp nhận';
                $order->save();
            }

            return view('client.cart.success');
        } else {
            return redirect()->route('client.carts.index')->with('message', 'Thanh toán thất bại!');
        }
    }
}
