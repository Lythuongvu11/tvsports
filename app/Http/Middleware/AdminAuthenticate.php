<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $next($request); // Cho admin truy cập tất cả
        } elseif ($user->hasRole('staff')) {
            // Cho nhân viên truy cập các route liên quan đến sản phẩm, danh mục, đơn hàng
            if ($request->routeIs(['products.*', 'categories.*', 'orders.*'])) {
                return $next($request);
            } else {
                // Người dùng nhân viên muốn truy cập route không phù hợp, có thể điều hướng hoặc xử lý khác
                return redirect()->route('orders.index')->with('message', 'Bạn không có quyền truy cập vào trang này');
            }
        }

        return redirect()->route('admin.login');
    }
}
