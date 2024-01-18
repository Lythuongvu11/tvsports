<?php

namespace App\Composers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $cart;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\UserRepository  $users
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('countProductInCart', $this->countProductInCart());
    }

    public function countProductInCart()
    {
        if (Auth::guard('user')->check()) {
            $userId = Auth::guard('user')->user()->id;
            $cart = $this->cart->getBy($userId);

            if ($cart) {
                $cart->loadProducts();
                return count($cart->products);
            } else {
                return 0;
            }
        } else {
            $sessionCart = session('cart', []);

            if (!is_array($sessionCart)) {
                $sessionCart = [];
            }

            return count($sessionCart);
        }
    }
}


