<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\StoreCategory;
use Illuminate\Http\Request;
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
        Validator::make($request->all(), [
            'name'=>'required|string',
            'image' => 'required',
        ])->validate();

        if ($request->hasfile('image')) {

            // hapus image_path dari DB
            $imagedel = ProductCategory::find($id);
            $imagedel -> delete();

            $files = $request->file('image');
            foreach($files as $file) {
                $image  = ProductCategory::find($id);
                $name   = time().'.'.$file->getClientOriginalName();
                $path   = public_path('/storage/product-category');
                $file  -> move($path, $name);
                $image -> name = $request->name;
                $image -> image_path=$name;
                $image -> update();
            }
            return redirect('admin/categories')->with("success", "Kategori Produk berhasi diubah");
        }
    }

}
