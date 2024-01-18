<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class   OderController extends Controller
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function index()
    {
        $orders = $this->order->getWithPaginateBy(Auth::guard('user')->user()->id, 10) ;
        return view('client.orders.index', compact('orders'));
    }
    public function cancel($id)
    {
        $order = $this->order->findOrFail($id);
        $order->update([
            'status' => 'Hủy'
        ]);
        $order->save();
        return redirect()->back()->with('success', 'Hủy đơn hàng thành công');
    }
}
