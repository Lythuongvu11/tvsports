<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = $this->order->latest('id')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    public function updateStatus(Request $request ,$id)
    {
        $order =  $this->order->findOrFail($id);
        $order->update(['status' => $request->status]);
        return  response()->json([
            'message' => 'success'
        ], Response::HTTP_OK);

    }
    public function show($id)
    {
        $order = $this->order->findOrFail($id);
        $products = ProductOrder::with('product')->where('order_id', $order->id)->get();
        return view('admin.orders.show', compact('order', 'products'));
    }

}
