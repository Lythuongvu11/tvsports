<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[

            ['name' => 'admin', 'display_name' => 'admin', 'group' => 'hệ thống'],
            ['name' => 'nhân viên', 'display_name' => 'Nhân viên', 'group' => 'hệ thống'],
            ['name' => 'người dùng', 'display_name' => 'Người dùng', 'group' => 'người dùng'],
        ];
        foreach($roles as $role){
            Role::updateOrCreate($role);
        }

        $permissions =[
            ['name' => 'thêm người dùng', 'display_name' => 'Thêm người dùng', 'group' => 'Người dùng'],
            ['name' => 'cập nhật người dùng', 'display_name' => 'Cập nhật  người dùng', 'group' => 'Người dùng'],
            ['name' => 'xem người dùng', 'display_name' => 'Xem người dùng', 'group' => 'Người dùng'],
            ['name' => 'xóa người dùng', 'display_name' => 'Xóa người dùng', 'group' => 'Người dùng'],

            ['name' => 'thêm vai trò', 'display_name' => 'Thêm vai trò', 'group' => 'Vai trò'],
            ['name' => 'cập nhật vai trò', 'display_name' => 'Cập nhật vai trò', 'group' => 'Vai trò'],
            ['name' => 'xem vai trò', 'display_name' => 'Xem vai trò', 'group' => 'Vai trò'],
            ['name' => 'xóa vai trò', 'display_name' => 'Xóa vai trò', 'group' => 'Vai trò'],

            ['name' => 'thêm danh mục', 'display_name' => 'Thêm danh mục', 'group' => 'Danh mục'],
            ['name' => 'cập nhật danh mục', 'display_name' => 'Cập nhật danh mục', 'group' => 'Danh mục'],
            ['name' => 'xem danh mục', 'display_name' => 'Xem danh mục', 'group' => 'Danh mục'],
            ['name' => 'xóa danh mục', 'display_name' => 'Xóa danh mục', 'group' => 'Danh mục'],

            ['name' => 'thêm sản phẩm', 'display_name' => 'Thêm sản phẩm', 'group' => 'Sản phẩm'],
            ['name' => 'cập nhật sản phẩm', 'display_name' => 'Cập nhật sản phẩm', 'group' => 'Sản phẩm'],
            ['name' => 'xem sản phẩm', 'display_name' => 'Xem sản phẩm', 'group' => 'Sản phẩm'],
            ['name' => 'xóa sản phẩm', 'display_name' => 'Xóa sản phẩm', 'group' => 'Sản phẩm'],

            ['name' => 'thêm phiếu giảm giá', 'display_name' => 'Thêm phiếu giảm giá', 'group' => 'Phiếu giảm giá'],
            ['name' => 'cập nhật phiếu giảm giá', 'display_name' => 'Cập nhật phiếu giảm giá', 'group' => 'Phiếu giảm giá'],
            ['name' => 'xem phiếu giảm giá', 'display_name' => 'Xem phiếu giảm giá', 'group' => 'Phiếu giảm giá'],
            ['name' => 'xóa phiếu giảm giá', 'display_name' => 'Xóa phiếu giảm giá', 'group' => 'Phiếu giảm giá'],
        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate($permission);
        }
    }
}
