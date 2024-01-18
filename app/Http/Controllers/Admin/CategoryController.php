<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories= $this->category->latest('id')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories= $this->category->getParents();
        return view('admin.categories.create', compact('parentCategories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $dataCreate= $request->all();
        $category = $this->category->create($dataCreate);
        return redirect()->route('categories.index')->with(['message'=> 'Tạo danh mục '. $category->name. ' thành công']);
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
        $category = $this->category->findOrFail($id);
        $parentCategories = $this->category->getParents();

        return view('admin.categories.edit', compact('category',  'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataUpdate = $request->all();
        $category = $this->category->findOrFail($id);

        // Kiểm tra nếu có thay đổi danh mục cha
        if ($request->has('edit_parent_id') && $request->get('edit_parent_id') != $category->parent_id) {
            // Cập nhật lại parent_id
            $category->parent_id = $request->get('edit_parent_id');
        }

        $category->update($dataUpdate);
        return redirect()->route('categories.index')->with(['message'=> 'Chỉnh sửa danh mục '. $category->name. ' thành công']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with(['message'=> 'Xóa danh mục '. $category->name. ' thành công']);
    }
}
