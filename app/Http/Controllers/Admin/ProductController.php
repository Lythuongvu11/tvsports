<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class ProductController extends Controller
{
    protected $category;
    protected $product;

    public function __construct(Category $category, Product $product)
    {
        $this->category = $category;
        $this->product = $product;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->product->latest('id');

        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', "%$search%");
        }

        $products = $query->paginate(5);

        return view('admin.products.index', compact('products', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories= $this->category->getParents();
        return view('admin.products.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $validatedData = $request->all();
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('uploads/products/' . $filename);
        ImageIntervention::make($image)->save($path);
        $product = $this->product->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'sale' => $validatedData['sale'],
            'price' => $validatedData['price'],
            'image' => 'uploads/products/' . $filename,
            'hot' => $request->has('hot'),
        ]);
        $productDetail = ProductDetail::create([
            'size' => $validatedData['size'],
            'color' => $validatedData['color'],
            'quantity' => $validatedData['quantity'],
            'product_id' => $product->id,
        ]);
        if ($request->hasFile('image_products')) {
            foreach ($request->file('image_products') as $key => $imageProduct) {
                $filename = time() . $key . '.' . $imageProduct->getClientOriginalExtension();
                $path = public_path('uploads/products/secondary/' . $filename);
                ImageIntervention::make($imageProduct)->save($path);

                // Lưu đường dẫn vào bảng image_products
                $product->images()->create([
                    'path' => 'uploads/products/secondary/' . $filename,
                ]);
            }
        }
        $product->details()->save($productDetail);
        $product->categories()->attach($validatedData['category_ids']);
        return redirect()->route('products.index')->with('message', 'Tạo mới sản phẩm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with(['categories', 'details'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product->with(['categories', 'details','images'])->findOrFail($id);
        $parentCategories = $this->category->getParents();
        return view('admin.products.edit', compact('parentCategories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $validatedData = $request->all();
        $product = $this->product->findOrFail($id);
        $oldImage = $product->image;
        $oldImages = $product->images->pluck('path')->toArray();
        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'sale' => $validatedData['sale'],
            'price' => $validatedData['price'],
            'hot' => $request->has('hot'),
        ]);
        $product->categories()->sync($validatedData['category_ids']);
        $product->details()->update([
            'size' => $validatedData['size'],
            'color' => $validatedData['color'],
            'quantity' => $validatedData['quantity'],
        ]);
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($oldImage) {
                unlink(public_path($oldImage));
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/products/' . $filename);
            ImageIntervention::make($image)->save($path);

            $product->image = 'uploads/products/' . $filename;
            $product->save();
        }
        if ($request->hasFile('image_products')) {
            $product->images()->delete();
            foreach ($oldImages as $oldImage) {
                if (File::exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
            foreach ($request->file('image_products') as $key => $imageProduct) {
                $filename = time() . $key . '.' . $imageProduct->getClientOriginalExtension();
                $path = public_path('uploads/products/secondary/' . $filename);
                ImageIntervention::make($imageProduct)->save($path);

                // Lưu đường dẫn vào bảng image_products
                $product->images()->create([
                    'path' => 'uploads/products/secondary/' . $filename,
                ]);
            }
        }

        return redirect()->route('products.index')->with('message', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->findOrFail($id);
        $oldImage = $product->image;
        $oldImages = $product->images->pluck('path')->toArray();
        if ($oldImage) {
            unlink(public_path($oldImage));
        }
        foreach ($oldImages as $oldImage) {
            if (File::exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }
        if ($product->details) {
            $product->details->delete();
        }
        $product->categories()->detach();
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Xóa sản phẩm thành công.');
    }
}
