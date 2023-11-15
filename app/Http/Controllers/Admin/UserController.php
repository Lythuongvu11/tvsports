<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $user;
    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    protected function deleteOldAvatar($oldAvatarPath)
    {
        if (File::exists(public_path($oldAvatarPath))) {
            File::delete(public_path($oldAvatarPath));
        }
    }


    public function index()
    {
        $users = $this->user::paginate(3);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->role->all()->groupBy('group');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        $image = $request->file('avatar');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('uploads/users/' . $filename);
        Image::make($image)->save($path);
        $dataCreate['avatar'] = 'uploads/users/' . $filename;
        $user = $this->user->create($dataCreate);
        $user->roles()->attach($dataCreate['role_ids']);
        return redirect()->route('users.index')->with(['message' => 'Thêm mới thành công']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->user->findOrFail($id)->load('roles');
        $roles = $this->role->all()->groupBy('group');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = $this->user->findOrFail($id);
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
        $user->roles()->sync($dataUpdate['role_ids']);
        return redirect()->route('users.index')->with(['message' => 'Cập nhật thành công']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar) {
            $this->deleteOldAvatar($user->avatar);
        }
        $user->delete();

        return redirect()->route('users.index')->with(['message' => 'Xóa thành công']);
    }
}
