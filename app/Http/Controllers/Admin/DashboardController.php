<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $user;
    protected $category;
    protected $order;
    protected $product;
    protected $coupon;
    protected $role;

    public function __construct(
        User $user,
        Category $category,
        Order $order,
        Product $product,
        Coupon $coupon,

    ) {
        $this->user = $user;
        $this->category = $category;
        $this->order = $order;
        $this->product = $product;
        $this->coupon = $coupon;
    }
    public function showDashboard()
    {
        $userCount = $this->user->count();
        $categoryCount = $this->category->count();
        $productCount = $this->product->count();
        $couponCount = $this->coupon->count();
        $orders = $this->order->latest('id')->take(5)->get();
        $newCustomers = $this->user->has('orders')->latest('created_at')->take(5)->get();
        // Dữ liệu doanh thu theo tháng
        $monthlyData = $this->order->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        // Dữ liệu doanh thu theo ngày
        $dailyData = $this->order->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard.index', compact('userCount', 'categoryCount',
            'productCount', 'couponCount', 'orders', 'newCustomers', 'monthlyData', 'dailyData'));

    }

}
