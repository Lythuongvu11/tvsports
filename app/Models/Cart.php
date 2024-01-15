<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];
    public function products()
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'cart_id')->with('product');
    }
    public function loadProducts()
    {
        $this->products = $this->cartProducts()->get();
    }
    public function getBy($userId)
    {
        return $this->where('user_id', $userId)->first();
    }



}
