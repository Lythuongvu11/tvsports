<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_size',
        'product_quantity',
        'product_price',
        'product_color',
        'product_img'
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getBy(int $cartId, int $productId, string $productSize, string $productColor)
    {
        return $this->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->where('product_size', $productSize)
            ->where('product_color', $productColor)

            ->first();
    }
}
