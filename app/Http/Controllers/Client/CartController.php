<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Models\ProductOrder;
use App\Models\User;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use App\Mail\OrderConfirmation;

class CartController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $order;
    protected $productDetail;
    protected $user;

    public function __construct(
        Cart $cart,
        Product $product,
        CartProduct $cartProduct,
        Coupon $coupon,
        Order $order,
        ProductDetail $productDetail,
        User $user
    ) {
        $this->cart = $cart;
        $this->product = $product;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->order = $order;
        $this->productDetail = $productDetail;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::guard('user')->id();
        $sessionCart = Session::get('cart', []);

        // Kiểm tra xem giỏ hàng Session có sản phẩm không
        if (empty($sessionCart)) {
            // Nếu không có sản phẩm trong giỏ hàng Session
            if ($userId) {
                // Nếu người dùng đã đăng nhập, lấy giỏ hàng của người dùng đó
                $cart = $this->cart->where('user_id', $userId)->first();

                if (!$cart) {
                    // Nếu không tìm thấy giỏ hàng, tạo mới
                    $cart = new Cart();
                    $cart->user_id = $userId;
                    $cart->save();
                }

                // Lấy danh sách sản phẩm từ giỏ hàng mới tạo
                $cartProducts = $cart->cartProducts->toArray();
            } else {
                // Nếu người dùng chưa đăng nhập, không có sản phẩm trong giỏ hàng
                $cartProducts = [];
            }
        } else {
            // Nếu có sản phẩm trong giỏ hàng Session
            if ($userId) {
                // Nếu người dùng đã đăng nhập
                $cart = $this->cart->where('user_id', $userId)->first();

                if ($cart) {
                    // Hợp nhất sản phẩm trong giỏ hàng Session vào giỏ hàng của người dùng đã đăng nhập
                    foreach ($sessionCart as $item) {
                        $existingCartProduct = $cart->cartProducts()
                            ->where('product_id', $item['product_id'])
                            ->where('product_name', $item['product_name'])
                            ->where('product_size', $item['product_size'])
                            ->where('product_color', $item['product_color'])
                            ->first();

                        if ($existingCartProduct) {
                            // Nếu sản phẩm đã tồn tại trong giỏ hàng của người dùng, cập nhật số lượng
                            $existingCartProduct->update([
                                'product_quantity' => $existingCartProduct->product_quantity + $item['product_quantity'],
                            ]);
                        } else {
                            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng của người dùng
                            $cartProduct = new CartProduct([
                                'cart_id' => $cart->id,
                                'product_id' => $item['product_id'],
                                'product_name' => $item['product_name'],
                                'product_img' => $item['product_img'],
                                'product_size' => $item['product_size'],
                                'product_quantity' => $item['product_quantity'],
                                'product_color' => $item['product_color'],
                                'product_price' => $item['product_price'],
                            ]);
                            $cart->cartProducts()->save($cartProduct);
                        }
                    }
                    // Xóa giỏ hàng Session sau khi hợp nhất
                    Session::forget('cart');
                    // Lấy danh sách sản phẩm từ giỏ hàng của người dùng đã đăng nhập
                    $cartProducts = $cart->cartProducts->toArray();
                } else {
                    // Nếu người dùng đã đăng nhập nhưng chưa có giỏ hàng, sử dụng giỏ hàng Session
                    $cartProducts = $sessionCart;
                }
            } else {
                // Nếu người dùng chưa đăng nhập, sử dụng giỏ hàng Session
                $cartProducts = $sessionCart;
            }
        }

        // Tính tổng giá trị giỏ hàng
        $totalPrice = $this->calculateTotalPrice($cartProducts);
        $totalAmount = $this->calculateTotalAmount($totalPrice, 0, session('discount_amount_price', 0));

        return view('client.cart.index', compact('cartProducts', 'totalPrice', 'totalAmount'));
    }

     function calculateTotalPrice($cartProducts)
    {
        $totalPrice = 0;
        foreach ($cartProducts as $item) {
            $totalPrice += $item['product_price'] * $item['product_quantity'];
        }
        return $totalPrice;
    }
    function calculateTotalAmount($totalPrice, $shippingCost, $discountAmount = 0) {
        if (!is_numeric($discountAmount)) {
            $discountAmount = 0;
        }

        // Tính tổng đơn hàng
        $totalAmount = $totalPrice + $shippingCost - $discountAmount;

        // Trả về kết quả
        return $totalAmount;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addToCart(Request $request)
    {
        $product = $this->product->with('details')->findOrFail($request->product_id);

        // Kiểm tra số lượng sản phẩm
        if ($product->details->quantity < $request->input('product_quantity')) {
            return back()->with('message', 'Số lượng sản phẩm không đủ!');
        }

        // Kiểm tra nếu người dùng đã chọn kích thước và màu sắc
        if (!$request->input('product_size') || !$request->has('product_color')) {
            return back()->with('message', 'Vui lòng chọn kích thước và màu sắc sản phẩm!');
        }

        // Lấy ID người dùng
        $userId = Auth::guard('user')->id();

        // Xử lý người dùng đã đăng nhập
        if ($userId) {
            // Kiểm tra giỏ hàng hiện có của người dùng
            $cart = $this->cart->where('user_id', $userId)->first();

            if (!$cart) {
                // Tạo giỏ hàng mới nếu không tồn tại
                $cart = new Cart();
                $cart->user_id = $userId;
                $cart->save();
            }

            $cartProduct = new CartProduct();
            $cartProduct->cart_id = $cart->id;
            $cartProduct->product_name = $product->name;
            $cartProduct->product_id = $product->id;
            $cartProduct->product_img = $product->image;
            $cartProduct->product_size = $request->input('product_size');
            $cartProduct->product_quantity = $request->input('product_quantity');
            $cartProduct->product_color = $request->input('product_color');
            $cartProduct->product_price = $product->price;
            $cartProduct->save();
        } else {
            // Xử lý người dùng khách với phiên
            $sessionCart = Session::get('cart', []);

            if (!is_array($sessionCart)) {
                $sessionCart = [];
            }

            $sessionCart[] = [
                'product_id' => $product->id,
                'product_img' => $product->image,
                'product_name' => $product->name,
                'product_size' => $request->input('product_size'),
                'product_quantity' => $request->input('product_quantity'),
                'product_color' => $request->input('product_color'),
                'product_price' => $product->price,
            ];

            // Lưu giỏ hàng phiên đã cập nhật
            Session::put('cart', $sessionCart);
        }

        return back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function showCheckout()
    {
        $cart = null;
        $user = $this->user->find(Auth::guard('user')->id());
        // Kiểm tra người dùng đã đăng nhập
        if (Auth::guard('user')->check()) {
            $userId = Auth::guard('user')->id();
            $cart = $this->cart->where('user_id', $userId)->first();
        } else {
            $sessionCart = Session::get('cart', []);

            // Kiểm tra nếu giỏ hàng phiên tồn tại
            if (!empty($sessionCart)) {
                $cart = new Cart();
                $cart->loadProducts();

                // Gán danh sách sản phẩm của giỏ hàng phiên vào giỏ hàng
                $cart->products = $sessionCart;
            }
        }
        if (!$cart) {
            return redirect()->back()->with('message', 'Giỏ hàng của bạn đang trống!');
        }
        $membershipDiscount = 0;
        $userMembershipLevel = $this->getUserMembershipLevel(Auth::guard('user')->id());
        if ($userMembershipLevel) {
            switch ($userMembershipLevel) {
                case 'Bạc':
                    $membershipDiscount = 15000;
                    break;
                case 'Vàng':
                    $membershipDiscount = 30000;
                    break;
                case 'Bạch kim':
                    $membershipDiscount = 50000;
                    break;
                case 'Kim cương':
                    $membershipDiscount = 100000;
                    break;

                default:
                    break;
            }
        }
        $specialBirthdayDiscount = 0;
        if (date('m-d') === date('m-d', strtotime($user->birthday))) {
            $specialBirthdayDiscount = 20000;
        }
        $finalDiscount = session('discount_amount_price', 0) + $membershipDiscount+ $specialBirthdayDiscount;
        $totalPrice = $this->calculateTotalPrice($cart->products);
        $totalAmount = $this->calculateTotalAmount($totalPrice, 30000, $finalDiscount);

        // Kiểm tra nếu không có giỏ hàng
        if (!$cart) {
            return redirect()->back()->with('message', 'Giỏ hàng của bạn đang trống!');
        }

        return view('client.cart.checkout', compact('cart', 'totalPrice',
            'totalAmount', 'membershipDiscount','userMembershipLevel','specialBirthdayDiscount'));
    }
    protected function getUserMembershipLevel($userId)
    {
        $userPoints = UserPoint::where('user_id', $userId)->first();

        return $userPoints ? $userPoints->membership_level : null;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $userId = Auth::guard('user')->id();

        // Lấy thông tin mã giảm giá
        $coupon = $this->coupon->firstWithExperyDate($couponCode, $userId);

        if ($coupon) {
            $message = 'Áp dụng mã giảm giá thành công!';
            $couponId = $coupon->id;

            // Kiểm tra xem mã giảm giá có liên kết với danh mục hay không
            if ($coupon->categories()->exists()) {
                // Mã giảm giá có liên kết với danh mục

                // Lấy danh sách sản phẩm trong giỏ hàng của người dùng
                $cartItems = Cart::where('user_id', $userId)->get();

                // Duyệt qua từng sản phẩm trong giỏ hàng
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->products;
//                    dd($product->pluck('id')->toArray());

                    // Kiểm tra xem sản phẩm có thuộc danh mục của mã giảm giá hay không
                    if ($this->isProductInCouponCategory($product, $coupon)) {
                        // Áp dụng giảm giá cho sản phẩm
                        $discountAmount = $coupon->value;
                    } else {
                        $discountAmount = 0;
                        // Báo lỗi nếu sản phẩm không thuộc danh mục của mã giảm giá
                        $message = 'Mã giảm giá không áp dụng cho sản phẩm này!';
                    }
                }
            } else {
                // Mã giảm giá không liên kết với danh mục
                $discountAmount = $coupon->value;
            }

            // Lưu thông tin mã giảm giá vào Session
            Session::put('coupon_id', $couponId);
            Session::put('discount_amount_price', $discountAmount);
            Session::put('coupon_code', $couponCode);
        } else {
            // Xóa thông tin mã giảm giá khỏi Session nếu không hợp lệ
            Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
            $message = 'Mã giảm giá không tồn tại hoặc đã hết hạn!';
        }

        return redirect()->back()->with('message', $message);
    }

    protected function isProductInCouponCategory($product, $coupon)
    {
        // Kiểm tra xem sản phẩm có liên kết với mã giảm giá và mã giảm giá có danh mục không
        if ($coupon && $coupon->categories()->exists()) {
            // Lấy danh sách danh mục của sản phẩm thông qua bảng trung gian
            $productCategories = $product->pluck('id')->toArray();

            // Kiểm tra xem sản phẩm thuộc danh mục của mã giảm giá hay không
            return count(array_intersect($productCategories, $coupon->categories->pluck('id')->toArray())) > 0;
        }

        return false;
    }

    public function processCheckout(CreateOrderRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['user_id'] = Auth::guard('user')->id();
        $dataCreate['status'] = 'Đang chờ xử lý';
        $dataCreate['total'] = $request->input('totalAmount');
        $dataCreate['ship'] = $request->input('ship');
        $dataCreate['payment'] = $request->input('payment');
        if ($request->input('note') == null) {
            $dataCreate['note'] = 'Không có ghi chú';
        } else {
            $dataCreate['note'] = $request->input('note');
        }

        $order=$this->order->create($dataCreate);
        $couponId = Session::get('coupon_id');
        if($couponId){
            $coupon = $this->coupon->find(Session::get('coupon_id'));
            if ($coupon) {
                $coupon->users()->attach(Auth::guard('user')->id(), ['value' => $coupon->value]);
            }
        }
        $cart = $this->cart->where('user_id', Auth::guard('user')->id())->first();
        $productOrders = [];
        foreach ($cart->products as $product) {
            $productOrders[] = [
                'product_size' => $product['product_size'],
                'product_color' => $product['product_color'],
                'product_quantity' => $product['product_quantity'],
                'product_price' => $product['product_price'],
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        ProductOrder::insert($productOrders);
        $cart->cartProducts()->delete();
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        $pointsEarned = floor($order->total / 100000);
        $this->addPointsToUser(Auth::guard('user')->id(), $pointsEarned);
        $this->updateMembershipLevel(Auth::guard('user')->id());
        Mail::to(Auth::guard('user')->user()->email)->send(new OrderConfirmation($order));
        if($request->input('payment')=='bank_transfer'){
            return redirect()->route('vnpay.payment.request', $order->id);
        } else {
            return view('client.cart.success');
        }
    }
    protected function addPointsToUser($userId, $points)
    {
        $userPoints = UserPoint::where('user_id', $userId)->first();

        if (!$userPoints) {
            // Nếu người dùng chưa có điểm, tạo bản ghi mới
            UserPoint::create([
                'user_id' => $userId,
                'points' => $points,
                'membership_level' => null,
            ]);
        } else {
            // Nếu người dùng đã có điểm, cộng thêm điểm mới
            $userPoints->increment('points', $points);
        }
    }
    protected function updateMembershipLevel($userId)
    {
        $userPoints = UserPoint::where('user_id', $userId)->first();

        if ($userPoints) {
            if ($userPoints->points >=50 && $userPoints->points <=100) {
                $userPoints->update(['membership_level' => 'Bạc']);
            } elseif ($userPoints->points <= 500) {
                $userPoints->update(['membership_level' => 'Vàng']);
            } elseif ($userPoints->points <= 1000) {
                $userPoints->update(['membership_level' => 'Bạch kim']);
            } elseif ($userPoints->points >= 1001) {
                $userPoints->update(['membership_level' => 'Kim cương']);
            } else {
                $userPoints->update(['membership_level' => null]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $productId = $request->input('productId');
        $userId = Auth::id();
        // Validate token CSRF

        // Xử lý xóa sản phẩm nếu người dùng đã đăng nhập
        if ($userId) {
            $cartProduct = CartProduct::where('product_id', $productId)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();

            if ($cartProduct) {
                $confirm = request()->input('confirm');

                if ($confirm) {
                    $cartProduct->delete();
                } else {
                    return response()->json(['success' => false]);
                }
            }
        } else {
            // Xử lý xóa sản phẩm nếu người dùng chưa đăng nhập
            $sessionCart = Session::get('cart', []);

            // Lọc ra các sản phẩm khác với sản phẩm cần xóa
            $sessionCart = array_filter($sessionCart, function ($item) use ($productId) {
                return $item['product_id'] != $productId;
            });

            // Lưu lại giỏ hàng phiên đã cập nhật
            Session::put('cart', $sessionCart);
        }

        return response()->json(['success' => true]);
    }

}
