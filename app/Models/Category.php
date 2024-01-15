<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];
    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getParentNameAttribute()
    {
        return optional($this->parent)->name;
    }
    public function getParents()
    {
        return Category::whereNull('parent_id')->with('children')->get(['id', 'name']);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    public function getBreadcrumbs()
    {
        $breadcrumbs = collect();

        $currentCategory = $this;

        while ($currentCategory) {
            $breadcrumbs->prepend($currentCategory);
            $currentCategory = $currentCategory->parent;
        }

        return $breadcrumbs;
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_category');
    }

    public function getAllSubcategories()
    {
        $allSubcategories = collect([$this]);

        foreach ($this->children as $child) {
            $allSubcategories = $allSubcategories->merge($child->getAllSubcategories());
        }

        return $allSubcategories;
    }
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }



}
