<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserAuthController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function showLoginForm()
    {
        return view('client.auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember = $request->has('remember');

        $user = $this->user->where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->hasRole('user')) {
                    Auth::guard('user')->login($user, $remember);
                    return redirect()->route('client.home');
                } else {
                    return redirect()->back()->with('message', 'Người dùng không có vai trò hợp lệ');
                }
            }
        }

        return redirect()->back()->with('message', 'Email hoặc mật khẩu không đúng');
    }
    public function logout()
    {
        auth('user')->logout();
        return redirect()->route('user.login');
    }

    public function showRegisterForm()
    {
        return view('client.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/users/' . $filename);
            Image::make($image)->save($path);
            $dataCreate['avatar'] = 'uploads/users/' . $filename;
        }
        $user = $this->user->create($dataCreate);
        $userRoleId = Role::where('name', 'user')->first()->id;
        $user->roles()->attach($userRoleId);
        return redirect()->route('user.login')->with(['message' => 'Đăng ký thành công, vui lòng đăng nhập']);
    }

    public function showForgotPasswordForm()
    {
        return view('client.auth.forgotPassword');
    }
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|exists:users,email'],
            [
                'email.required' => 'Email không được để trống',
                'email.exists' => 'Email không tồn tại trong hệ thống',
            ]);
        $token= strtoupper(Str::random(10));
        $user = $this->user->where('email', $request->email)->first();
        if($user && $user->hasRole('user')){
            $user->update(['token'=>$token]);
            $mailSent = Mail::send('client.auth.mail_reset', compact('user'), function ($email) use ($user) {
                $email->subject('TVSports - Reset Password');
                $email->to($user->email, $user->name);
            });
            if ($mailSent) {
                return redirect()->back()->with(['success' => 'Vui lòng kiểm tra email để lấy lại mật khẩu']);
            } else {
                return redirect()->back()->withErrors(['email' => 'Có lỗi trong quá trình gửi email']);
            }

        }

        return redirect()->back()->withErrors(['email' => 'Email không tồn tại']);
    }

    public function getPassword(Request $request,$token)
    {
        $user = $this->user->where('token', $token)->first();
        if($user){
            return view('client.auth.resetPassword',compact('user','token'));
        }
        return redirect()->route('user.login')->withErrors(['message'=>'Token không hợp lệ']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'user' => 'required|exists:users,id',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        $user = $this->user->where('token', $request->token)->first();
        if($user){
            $user->update(['password'=>Hash::make($request->password),'token'=>null]);
            return redirect()->route('user.login')->with(['success'=>'Đổi mật khẩu thành công']);
        }
        return redirect()->route('user.login')->withErrors(['message'=>'Token không hợp lệ']);
    }

}
