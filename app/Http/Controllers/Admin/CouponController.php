<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupons\CreateCouponRequest;
use App\Http\Requests\Coupons\UpdateCouponRequest;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponCategory;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = $this->coupon->latest('id')->paginate(5);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();
        return view('admin.coupons.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCouponRequest $request)
    {
        $dataCreate = $request->all();
        $coupon = $this->coupon->create($dataCreate);
        $selectedCategories = $request->input('category_ids', []);
        if (!empty($selectedCategories)) {
            foreach ($selectedCategories as $categoryId) {
                CouponCategory::create([
                    'coupon_id' => $coupon->id,
                    'category_id' => $categoryId,
                ]);
            }
        }
        return redirect()->route('coupons.index')->with('message', 'Thêm mới mã giảm giá thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = $this->coupon->findOrFail($id);
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get();
        $selectedCategories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];
        return view('admin.coupons.edit', compact('coupon', 'categories', 'selectedCategories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, string $id)
    {
        $coupon = $this->coupon->findOrFail($id);

        $dataUpdate = $request->all();
        $coupon->update($dataUpdate);
        $selectedCategories = $request->input('category_ids', []);
        $coupon->categories()->sync($selectedCategories);
        return redirect()->route('coupons.index')->with('message', 'Cập nhật mã giảm giá thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = $this->coupon->findOrFail($id);
        $coupon->categories()->detach();
        $coupon->delete();
        return redirect()->route('coupons.index')->with('message', 'Xóa mã giảm giá thành công');
    }
}
