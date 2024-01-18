<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AccountUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    protected function deleteOldAvatar($oldAvatarPath)
    {
        if (File::exists(public_path($oldAvatarPath))) {
            File::delete(public_path($oldAvatarPath));
        }
    }
    public function index()
    {
        return view('client.account.index');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('client.account.edit', compact('user'));
    }
    public function update(AccountUpdate $request)
    {
        $user = Auth::user();
        $dataUpdate = $request->all();
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('avatar')) {
            $this->deleteOldAvatar($user->avatar);

            $image = $request->file('avatar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/users/' . $filename);
            Image::make($image)->save($path);
            $dataUpdate['avatar'] = 'uploads/users/' . $filename;
        } else {
            $dataUpdate['avatar'] = $user->avatar;
        }
        $user->update($dataUpdate);
        return redirect()->route('user.profile')->with('success', 'Cập nhật tài khoản thành công.');
    }
}
