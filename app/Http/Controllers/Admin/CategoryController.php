<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::all();
        $storeCategories = StoreCategory::all();

        return view('admin.category.index', compact('productCategories','storeCategories'));
    }

    public function storeCateProd(Request $request)
    {
        Validator::make($request->all(), [
            'name'=>'required|string',
            'image' => 'required',
        ])->validate();

        if ($request->hasfile('image')) {
            $files = $request->file('image');
            foreach($files as $file) {
                $image  = new ProductCategory;
                $name   = time().'.'.$file->getClientOriginalName();
                $path   = public_path('/storage/product-category');
                $file  -> move($path, $name);
                $image -> name = $request->name;
                $image -> image_path=$name;
                $image -> save();
            }
            return redirect('admin/categories')->with("success", "Kategori Produk berhasi ditambahkan");
        }
    }

    public function storeCateStore(Request $request)
    {
        Validator::make($request->all(), [
            'nama_kategori'=>'required|string',
            'gambar_kategori_lapak' => 'required',
        ])->validate();

        if ($request->hasfile('gambar_kategori_lapak')) {
            $files = $request->file('gambar_kategori_lapak');
            foreach($files as $file) {
                $image  = new StoreCategory;
                $name   = time().'.'.$file->getClientOriginalName();
                $path   = public_path('/storage/store-category');
                $file  -> move($path, $name);
                $image -> name = $request-> nama_kategori;
                $image -> image_path = $name;
                $image -> save();
            }
            return redirect('admin/categories')->with("success", "Kategori Lapak berhasi ditambahkan");
        }
    }

    public function updateCateProd(Request $request, $id)
    {
        $data = $request->all();
        Validator::make($request->all(), [
            'name'=>'required|string',
        ])->validate();
        $category = ProductCategory::findOrFail($id);
        if($request -> hasFile('image'))
        {
            $path = public_path('storage/product-category/'.$category->image_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $file = $request ->file('image');
            $ext = $file->getClientOriginalName();
            $fileName = time().".".$ext;
            $path = public_path('/storage/product-category');
            $file->move($path, $fileName);
            $category->image_path = $fileName;
        }
        $category->name = $request->input('name');
        $category->update();
        return redirect('admin/categories')->with("success", "Kategori Produk berhasi diubah");
    }

    public function updateCateStore(Request $request, $id)
    {
        $data = $request->all();
        Validator::make($request->all(), [
            'name'=>'required|string',
        ])->validate();
        $category = StoreCategory::findOrFail($id);
        if($request -> hasFile('image'))
        {
            if (file_exists(public_path('storage/store-category/'.$category->image_path))) {
                unlink(public_path('storage/store-category/'.$category->image_path));
            }
            $file = $request ->file('image');
            $ext = $file->getClientOriginalName();
            $fileName = time().".".$ext;
            $path = public_path('/storage/store-category');
            $file->move($path, $fileName);
            $category->image_path = $fileName;
        }
        $category->name = $request->input('name');
        $category->update();
        return redirect('admin/categories')->with("success", "Kategori Lapak berhasi diubah");
    }

    public function deleteCateProd($id)
    {
        $prod_cate = ProductCategory::find($id);
        $product = Product::where('category_id',$id)->first();

        if ($prod_cate)
        {
            foreach ( $product->productImages as $image)
            {
                $prod_img_path = public_path('storage/product-image/'.$image->image_path);
                if (file_exists($prod_img_path)) {
                    unlink($prod_img_path);
                }
            }
            $path = public_path('storage/product-category/'.$prod_cate->image_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $product->productImages()->delete();
            $product->delete();
            $prod_cate->delete();
            return back()->with('success', 'Kategori Produk berhasil dihapus.');
        }
        return back()->with('error', 'kategori id tidak ditemukan.');
    }

    public function deleteCateStore($id)
    {
        StoreCategory::findOrFail($id)->delete();
        return back()->with('success', 'Kategori Lapak di hapus.');
    }

}
