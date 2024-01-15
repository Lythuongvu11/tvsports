<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Client\UserAuthController;
use App\Http\Controllers\Client\OderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Client\AccountController;
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
Route::get('/', [HomeController::class,'index' ])->name('client.home');
Route::get('/sale', [HomeController::class,'sale' ])->name('client.home.sale');
Route::get('/hot', [HomeController::class,'hot' ])->name('client.home.hot');
Route::get('/new', [HomeController::class,'new' ])->name('client.home.new');
//product
Route::get('/products/{category_id?}', [ClientProductController::class,'index'])->name('client.products.index');
//detail
Route::get('/product-detail/{id}', [ClientProductController::class,'show'])->name('client.product.show');
//review
Route::post('/product-detail/{id}/review', [ClientProductController::class,'review'])->name('client.product.review');
//cart
Route::post('add-to-cart', [CartController::class,'addToCart'])->name('client.carts.add');
Route::get('cart', [CartController::class,'index'])->name('client.carts.index');
Route::delete('/cart/delete', [CartController::class, 'delete'])->name('client.carts.delete');
//coupon
Route::post('apply-coupon', [CartController::class,'applyCoupon'])->name('client.carts.apply_coupon');
Route::get('cart/checkout', [CartController::class,'showCheckout'])->middleware('require_login')->name('client.carts.checkout');
//checkout
Route::post('process-checkout', [CartController::class,'processCheckout'])->name('client.checkout.process');
//order
Route::get('list-order', [OderController::class,'index'])->name('client.orders.index');
Route::post('order/cancel/{id}', [OderController::class,'cancel'])->name('client.orders.cancel');
//payment
Route::get('vnpay/payment/request/{orderId}', [PaymentController::class,'paymentRequest'])->name('vnpay.payment.request');
Route::get('vnpay/payment/return', [PaymentController::class,'vnpayReturn'])->name('vnpay.payment.return');
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
Route::prefix('user')->group(function () {
    Route::get('/login', [UserAuthController::class,'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class,'login']);
    Route::post('/logout', [UserAuthController::class,'logout'])->name('user.logout');
    Route::get('/register', [UserAuthController::class,'showRegisterForm'])->name('user.register');
    Route::post('/register', [UserAuthController::class,'register']);

    Route::get('/forgot-password',[UserAuthController::class,'showForgotPasswordForm'])->name('user.forgotForm');
    Route::post('/forgot-password',[UserAuthController::class,'forgotPassword']);
    Route::get('/get-password/{token}',[UserAuthController::class,'getPassword'])->name('user.getPassword');
    Route::post('/get-password/update',[UserAuthController::class,'updatePassword'])->name('user.updatePassword');
})->middleware('user');
//profile
Route::middleware('auth:user')->group(function () {
    Route::get('/profile', [AccountController::class,'index'])->name('user.profile');
    Route::get('/profile/edit', [AccountController::class,'edit'])->name('user.profile.edit');
    Route::post('/profile/update', [AccountController::class,'update'])->name('user.profile.update');
});

//admin
Route::get('/admin/login', [AuthController::class,'showLoginForm' ])->name('admin.login');
Route::post('/admin/login', [AuthController::class,'login' ]);
Route::get('/admin/logout', [AuthController::class,'logout' ])->name('admin.logout');
Route::prefix('admin')->middleware('admin')->group(function () {
    //dashboard
    Route::get('/dashboard', [DashboardController::class,'showDashboard' ])->name('admin.dashboard');
    //role
    Route::resource('roles', RoleController::class);
    //user
    Route::resource('users', UserController::class);
    //category
    Route::resource('categories', CategoryController::class);
    //product
    Route::resource('products', ProductController::class);
    //coupon
    Route::resource('coupons', CouponController::class);
    //order
    Route::get('orders', [AdminOrderController::class,'index'])->name('orders.index');
    Route::post('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    //banner
    Route::resource('banners', BannerController::class);

});









