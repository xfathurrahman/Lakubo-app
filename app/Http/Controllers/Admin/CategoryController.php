<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function getProduct()
    {
        $productCategories = ProductCategory::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.category.products.index', compact('productCategories'));
    }

    public function getStore()
    {
        $storeCategories = StoreCategory::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.category.stores.index', compact('storeCategories'));
    }

    public function storeCateProd(CreateCategoryRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = new ProductCategory;
            $name = time() . '.' . $request->image->getClientOriginalExtension();
            $path = public_path('storage/product-categories/'.$name);
            Image::make($request->image->getRealPath())->resize(350, 350)->save($path);
            $image->name = $request->name;
            $image->image_path = $name;
            $image->save();
            return back()->with("success", "Kategori Produk berhasil ditambahkan");
        }
    }

    public function storeCateStore(CreateCategoryRequest $request)
    {
        if ($request->hasFile('image')) {
            $image  = new StoreCategory;
            $name   = time().'.'.$request->image->getClientOriginalExtension();
            $path   = public_path('storage/store-categories/'.$name);
            Image::make($request->image->getRealPath())->resize(350, 350)->save($path);
            $image -> name = $request->name;
            $image -> image_path = $name;
            $image -> save();
            return back()->with("success", "Kategori Lapak berhasil ditambahkan");
        }
    }

    public function updateCateProd(UpdateCategoryRequest $request, $id)
    {
        $prod_cate = ProductCategory::find($id);

        if (!$prod_cate) {
            return redirect()->back()->with('error', 'Kategori produk tidak ditemukan.');
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('storage/product-categories/'.$name);
            Image::make($image->getRealPath())->resize(350, 350)->save($path);
            if ($prod_cate->image_path) {
                Storage::delete('public/product-categories/'.$prod_cate->image_path);
            }
            $prod_cate->image_path = $name;
        }
        $prod_cate->name = $request->name;
        $prod_cate->save();
        return back()->with("success", "Kategori produk berhasil diubah.");
    }



    public function updateCateStore(UpdateCategoryRequest $request, $id)
    {
        $store_cate = StoreCategory::find($id);

        if (!$store_cate) {
            return redirect()->back()->with('error', 'Kategori Lapak tidak ditemukan.');
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('storage/store-categories/'.$name);
            Image::make($image->getRealPath())->resize(350, 350)->save($path);
            if ($store_cate->image_path) {
                Storage::delete('public/store-categories/'.$store_cate->image_path);
            }
            $store_cate->image_path = $name;
        }
        $store_cate->name = $request->name;
        $store_cate->save();
        return back()->with("success", "Kategori Lapak berhasil diubah.");
    }

    public function deleteCateProd($id)
    {
        $prod_cate = ProductCategory::find($id);
        if ($prod_cate)
        {
            $path = public_path('storage/product-categories/'.$prod_cate->image_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $prod_cate->delete();
            return back()->with('success', 'Kategori Produk berhasil dihapus.');
        }
        return back()->with('error', 'kategori Produk tidak ditemukan.');
    }

    public function deleteCateStore($id)
    {
        $store_cate = StoreCategory::find($id);
        if ($store_cate)
        {
            $path = public_path('storage/store-categories/'.$store_cate->image_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $store_cate->delete();
            return back()->with('success', 'Kategori Lapak berhasil dihapus.');
        }
        return back()->with('error', 'kategori Lapak tidak ditemukan.');
    }

}
