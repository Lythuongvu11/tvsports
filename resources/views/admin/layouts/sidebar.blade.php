<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="h5 app-sidebar__user-designation">Trang quản trị admin</p>
        </div>
    </div>
    <hr/>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{ request()->routeIs('dashboard')? 'active' :''}}" href="{{ route('admin.dashboard') }}"
            ><i class="app-menu__icon bx bx-tachometer"></i
                ><span class="app-menu__label">Thống kê</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('roles.*')? 'active' :''}}" href="{{ route('roles.index') }}"
            ><i class="app-menu__icon bx bx-user-check"></i
                ><span class="app-menu__label">Quản lý vai trò</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('users.*')? 'active' :''}}" href="{{ route('users.index')}}"
            ><i class="app-menu__icon bx bx-user-voice"></i
                ><span class="app-menu__label">Quản lý người dùng</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('categories.*')? 'active' :''}}" href="{{ route('categories.index') }}"
            ><i class="app-menu__icon bx bx-category"></i
                ><span class="app-menu__label">Quản lý danh mục</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('products.*')? 'active' :''}}" href="{{ route('products.index') }}"
            ><i class="app-menu__icon bx bx-purchase-tag-alt"></i
                ><span class="app-menu__label">Quản lý sản phẩm</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('coupons.*')? 'active' :''}}" href="{{ route('coupons.index') }}"
            ><i class="app-menu__icon bx bx-dollar"></i
                ><span class="app-menu__label">Quản lý mã giảm giá</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('orders.*','admin.orders.show')? 'active' :''}}" href="{{ route('orders.index') }}"
            ><i class="app-menu__icon bx bx-cart-add"></i
                ><span class="app-menu__label">Quản lý đơn hàng</span></a
            >
        </li>
        <li>
            <a class="app-menu__item {{ request()->routeIs('banners.*')? 'active' :''}}" href="{{ route('banners.index') }}"
            ><i class="app-menu__icon bx bxs-invader"></i
                ><span class="app-menu__label">Quản lý Banner</span></a
            >
        </li>

{{--        <li>--}}
{{--            <a class="app-menu__item" href=""--}}
{{--            ><i class="app-menu__icon bx bx-id-card"></i>--}}
{{--                <span class="app-menu__label">Quản lý nhân viên</span></a--}}
{{--            >--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a class="app-menu__item" href=""--}}
{{--            ><i class="app-menu__icon bx bx-cog"></i--}}
{{--                ><span class="app-menu__label">Cài đặt hệ thống</span></a--}}
{{--            >--}}
{{--        </li>--}}
    </ul>
</aside>
