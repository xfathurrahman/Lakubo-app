<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        if (auth()->user()->stores)
        {
            $listProducts = Product::with('productCategories','productImages','stores')
                ->where('store_id', Auth::user()->stores->id)
                ->Paginate(10)
                ->onEachSide(2);
            return view('seller.products.index', compact('listProducts'));
        }
        return view('seller.products.index');
    }

    public function create()
    {
        $listCateProd = ProductCategory::all();
        return view('seller.products.create', compact('listCateProd'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $request->validated();

        $product  = new Product;
        $product -> name = $data['name'];
        $product -> price = $data['price'];
        $product -> category_id = $data['kategori'];
        $product -> description =  $data['description'];
        $product -> quantity =  $data['quantity'];
        $product -> store_id = Auth::user()->stores->id;
        $product -> save();

        if ($request->hasfile('files')) {
            $files = $request->file('files');
            foreach($files as $file) {
                $image  = new ProductImage;
                $name   = time().'.'.$file->getClientOriginalName();
                $path   = public_path('/storage/product-image');
                $file  -> move($path, $name);
                $image -> product_id = $product->id;
                $image -> image_path=$name;
                $image -> save();
            }
        }
        if ($request->get('action') == 'save_and_new') {
            return redirect('seller/products/create')->with("success", "Produk berhasil ditambahkan");
        }

        return redirect('seller/products')->with("success", "Produk berhasil ditambahkan");
    }

    public function show($id)
    {
        // return view('seller.products.detail');
    }

    public function edit(Request $request, Product $product)
    {
        $listCateProd = ProductCategory::all();
        $productCategories = ProductCategory::where('id', $product->category_id)->first();

        return view('seller.products.edit', compact( 'product','listCateProd','productCategories'));
    }

    public function getImage()
    {
        $data = ProductImage::all();
        return response()->json($data);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        Validator::make($request->all(), [
            'name'=>'required|string|max:120',
            'kategori'=>'required',
            'price'=>'required|max:10',
            'quantity'=>'required|max:7',
            'description'=>'required|string|max:1000',
        ])->validate();

        if ($request->filled('old') || $request->hasFile('files'))
        {
            if ( $request->isNotFilled('old')) {
                DB::table('product_images')->where('product_id', $product->id)->delete();
            } elseif ($request->old)
            {
                DB::table('product_images')->where('product_id', $product->id)->whereNotIn('id', $request->old)->delete();
            }

            if ($request->hasfile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $image = new ProductImage();
                    $image_name = time() . '.' . $file->getClientOriginalName();
                    $path = public_path('/storage/product-image');
                    $file->move($path, $image_name);
                    $image->product_id = $product->id;
                    $image->image_path = $image_name;
                    $image->save();
                }
            }

            $product -> name = $data['name'];
            $product -> price = $data['price'];
            $product -> category_id = $data['kategori'];
            $product -> description =  $data['description'];
            $product -> quantity =  $data['quantity'];
            $product->update();

            return redirect('seller/products')->with('success', "Product $product->name berhasil di update");
        }
        return back()->with('error','Wajib menggunggah minimal 1 gambar produk.');
    }

    public function destroy($product)
    {
        $product = Product::find($product);
        if ($product)
        {
            foreach ( $product->productImages as $image)
            {
                $path = public_path('storage/product-image/'.$image->image_path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $product->productImages()->delete();
            $product->delete();
            return redirect('seller/products')->with('success', 'Produk berhasil di hapus.');
        }
        $product->delete();
        return redirect('seller/products')->with('success', 'Produk tidak memiliki gambar.');
    }
}
