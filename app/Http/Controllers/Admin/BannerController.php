<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\CreateBannerRequest;
use App\Http\Requests\Banners\UpdateBannerRequest;
use Illuminate\Http\Request;
use App\Models\Banner;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    protected $banner;
    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners= $this->banner->latest('id')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBannerRequest $request)
    {
        $dataCreate = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/banners/' . $filename);
            Image::make($image)->save($path);
            $dataCreate['image'] = 'uploads/banners/' . $filename;
        }
        $this->banner->create($dataCreate);
        return redirect()->route('banners.index')->with('message', 'Thêm mới banner thành công');

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
        $banner = $this->banner->findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, string $id)
    {
        $banner = $this->banner->findOrFail($id);
        $dataUpdate = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/banners/' . $filename);
            Image::make($image)->save($path);
            $dataUpdate['image'] = 'uploads/banners/' . $filename;
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
        }else {
            $dataUpdate['image'] = $banner->image;
        }
        $banner->update($dataUpdate);
        return redirect()->route('banners.index')->with('message', 'Cập nhật banner thành công');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = $this->banner->findOrFail($id);
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        $banner->delete();
        return redirect()->route('banners.index')->with('message', 'Xóa banner thành công');
    }
}
