<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $product;
    protected $category;
    protected $banner;
    public function __construct(Product $product, Category $category, Banner $banner)
    {
        $this->product = $product;
        $this->category = $category;
        $this->banner = $banner;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productsSale = $this->product->where('sale','>',0)->paginate(4);
        $productsNew = $this->product->latest('id')->paginate(4);
        $productsHot = $this->product->where('hot',1)->paginate(4);
        $banners = $this->banner->take(3)->get();
        return view('client.home.index',compact('productsNew','productsHot','productsSale','banners'));
    }
    public function sale()
    {
        $productsSale = $this->product->where('sale','>',0)->get();
        $banners = $this->banner->take(3)->get();
        return view('client.home.sale',compact('productsSale','banners'));
    }
    public function hot()
    {
        $productsHot = $this->product->where('hot',1)->get();
        $banners = $this->banner->take(3)->get();
        return view('client.home.hot',compact('productsHot','banners'));
    }
    public function new()
    {
        $productsNew = $this->product->latest('id')->take(8)->get();
        $banners = $this->banner->take(3)->get();
        return view('client.home.new',compact('productsNew','banners'));
    }
}
