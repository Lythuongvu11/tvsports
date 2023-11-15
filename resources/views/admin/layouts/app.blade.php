<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @yield('title','Quản trị Admin')
    </title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/main.css')}}" />
    <link
        rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css') }}"
    />
    <!-- or -->
    <link
        rel="stylesheet"
        href="{{ asset('https://unpkg.com/boxicons@latest/css/boxicons.min.css') }}"
    />
    <!-- Font-icon css-->
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}"
    />
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js') }}"></script>
    <link
        rel="stylesheet"
        href="{{ asset('https://use.fontawesome.com/releases/v5.8.2/css/all.css') }}"
    />
    <link
        rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css') }}"
    />
    <script src=" {{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js') }}" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js') }}" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
</head>
<body class="app sidebar-mini rtl">
<!-- Navbar-->
<header class="app-header">
    <!-- Sidebar toggle button--><a
        class="app-sidebar__toggle"
        href="#"
        data-toggle="sidebar"
        aria-label="Hide Sidebar"
    ></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <!-- User Menu-->
        <li>
            <a class="app-nav__item" href=""
            ><i class="bx bx-log-out bx-rotate-180"></i>
            </a>
        </li>
    </ul>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

@include('admin.layouts.sidebar')

<main class="app-content">
    @yield('content')
</main>
</body>
</html>

