<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function login()
    {
        $credentials = [
            'email' => request()->email,
            'password' => request()->password,
        ];
        if (auth()->attempt($credentials)) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }else if (auth()->user()->hasRole('staff')) {
                return redirect()->route('orders.index');
            }
            else {
                return redirect()->back()->with('message', 'Bạn không có quyền truy cập vào trang quản trị');
            }
        } else {
            return redirect()->back()->with('message', 'Email hoặc mật khẩu không đúng');
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
