<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sale',
        'price',
        'hot',
        'image',
    ];
    public function details()
    {
        return $this->hasOne(ProductDetail::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_product', 'product_id', 'category_id');
    }

    public function getBy($dataSearch, $categoryId)
    {
        return $this->whereHas('categories', fn($q) => $q->where('category_id', $categoryId))->paginate(10);
    }
    public function images()
    {
        return $this->hasMany(ImageProduct::class, 'product_id');
    }

}
