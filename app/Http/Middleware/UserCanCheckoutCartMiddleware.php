<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserCanCheckoutCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->route('user.login')->with('message', 'Bạn cần đăng nhập để thanh toán');
        }
        $cart = Cart::whereUserId(auth()->guard('user')->user()->id)->first();
        if (!$cart) {
            return redirect()->route('client.carts.index')->with('message', 'Giỏ hàng của bạn đang trống');
        }
        return $next($request);
    }
}
