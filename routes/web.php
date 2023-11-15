<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//home
Route::get('/', function () {
    return view('client.home.index');
})->name('home');
//shop
Route::get('/shop', function () {
    return view('client.shop.index');
})->name('shop');
//detail
Route::get('/detail', function () {
    return view('client.detail.index');
})->name('detail');
//cart
Route::get('/cart', function () {
    return view('client.cart.index');
})->name('cart');
//checkout
Route::get('/checkout', function () {
    return view('client.checkout.index');
})->name('checkout');
//blog
Route::get('/blog', function () {
    return view('client.blog.index');
})->name('blog');
Route::get('/blog/detail', function () {
    return view('client.blog.detail.index');
})->name('blog.detail');
//contact
Route::get('/contact', function () {
    return view('client.contact.index');
})->name('contact');
//login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
//signup
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');


//admin
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('admin.login');
Route::get('admin/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');
//role
Route::resource('roles', RoleController::class);
//user
Route::resource('users', UserController::class);
//Route::prefix('admin')->middleware('admin')->group(function () {
//    Route::get('/dashboard', function () {
//        return view('admin.dashboard.index');
//    })->name('admin.dashboard');
//});









