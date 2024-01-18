<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\CreateReviewRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientProductController extends Controller
{
    protected $product;

    public function __construct(Product $product,)
    {
        $this->product = $product;
    }


    public function index(Request $request, $category_id = null)
    {
        $categories = Category::withCount('products')->with('children.children')->latest('id')->get();
        $allProductsCount = $this->product->count();
        $selectedCategories = [];

        // Lấy danh sách tất cả các danh mục
        $categoriesQuery = Category::withCount('products')->with('children.children')->latest('id');

        if ($category_id !== null) {
            // Lấy sản phẩm theo danh mục và các danh mục con
            $mainCategory = Category::find($category_id);

            if ($mainCategory) {
                $subcategories = $mainCategory->getAllSubcategories()->pluck('id')->toArray();
            } else {
                $subcategories = [];
            }
            // Lấy danh mục được chọn và danh mục cha
            $selectedCategories = Category::with('parent')->find($category_id)->getBreadcrumbs();

            // Thêm điều kiện cho danh sách danh mục
            $categoriesQuery->whereIn('id', $subcategories);

            // Lấy sản phẩm theo danh mục
            $products = Product::whereHas('categories', function ($query) use ($subcategories) {
                $query->whereIn('categories.id', $subcategories);
            });
        } else {
            // Lấy tất cả sản phẩm
            $products = Product::query();
        }

        // Lọc giá
        $priceRanges = [
            1 => [
                'min' => 0,
                'max' => 500000,
            ],
            2 => [
                'min' => 500000,
                'max' => 1000000,
            ],
            3 => [
                'min' => 1000000,
                'max' => 2000000,
            ],
            4 => [
                'min' => 2000000,
                'max' => 5000000,
            ],
            5 => [
                'min' => 5000000,
                'max' => 10000000,
            ],
        ];
        $selectedPriceRanges = $request->input('price', []);

        if (is_string($selectedPriceRanges)) {
            $selectedPriceRanges = [$selectedPriceRanges];
        }

        if (!empty($selectedPriceRanges)) {
            $products->where(function ($query) use ($priceRanges, $selectedPriceRanges) {
                foreach ($selectedPriceRanges as $priceRange) {
                    $minPrice = $priceRanges[$priceRange]['min'];
                    $maxPrice = $priceRanges[$priceRange]['max'];

                    $query->orWhere(function ($q) use ($minPrice, $maxPrice) {
                        $q->where('price', '>=', $minPrice)
                            ->where('price', '<=', $maxPrice);
                    });
                }
            });
        }
        $searchQuery = $request->input('q');
        if ($searchQuery) {
            $products->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Sử dụng phân trang cho sản phẩm
        $products = $products->paginate(8);

        // Tính toán số lượng sản phẩm của từng danh mục
        $categories = $categoriesQuery->get();
        $categoriesCount = [];

        foreach ($categories as $category) {
            $count = $category->products_count;

            foreach ($category->children as $childCategory) {
                if ($childCategory) {
                    $count += $this->calculateProductsCount($childCategory);
                }
            }

            $categoriesCount[$category->id] = $count;
        }

        return view('client.products.index', compact('categories', 'products',
            'allProductsCount', 'selectedCategories', 'categoriesCount', 'priceRanges'))
            ->with('selectedPriceRange', $selectedPriceRanges)
            ->with('search', $searchQuery);
    }

    function calculateProductsCount($category)
    {
        $count = $category->products_count ?? 0;

        if ($category->children) {
            foreach ($category->children as $childCategory) {
                $count += $this->calculateProductsCount($childCategory);
            }
        }

        return $count;
    }


    public function show($id)
    {
        $product = $this->product->with('details', 'images')->findOrFail($id);
        // Lấy danh mục của sản phẩm hiện tại
        $categoryId = $product->categories->pluck('id');
        // Lấy ra các sản phẩm tương tự dựa trên cùng một danh mục
        $similarProducts = $this->product->whereHas('categories', function ($query) use ($categoryId) {
            $query->whereIn('categories.id', $categoryId);
        })
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        $carouselData = [];
        $productImages = $product->images;
        $carouselData[] = [
            'image' => asset($product->image),
        ];

        foreach ($productImages as $image) {
            $carouselData[] = [
                'image' => asset($image->path),
            ];
        }
        $reviews = Review::where('product_id', $id)->get();

        return view('client.products.detail', compact('product', 'similarProducts', 'carouselData', 'reviews'));
    }

    public function review(CreateReviewRequest $request, $id)
    {
        if (!Auth::guard('user')->check()) {
            return redirect()->route('user.login')->with('message', 'Bạn cần đăng nhập để đánh giá sản phẩm');
        }
        $dataCreate = $request->only('rating', 'comment');
        $dataCreate['user_name'] = Auth::guard('user')->user()->name;
        $dataCreate['product_id'] = $id;
        $review = Review::create($dataCreate);
        if ($review) {
            return redirect()->back()->with('success', 'Đánh giá sản phẩm thành công');
        }
        return redirect()->back()->with('message', 'Đánh giá sản phẩm thất bại');
    }
}
