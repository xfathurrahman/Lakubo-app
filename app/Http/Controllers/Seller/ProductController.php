<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        Validator::make($request->all(), [
            'name'=>'required|string|max:120',
            'kategori'=>'required',
            'price'=>'required|max:10',
            'quantity'=>'required|max:7',
            'description'=>'required|string|max:1000',
            'files' => 'required',
        ])->validate();

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
            return redirect('seller/products')->with("success", "Produk berhasi ditambahkan");
        }
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

        return redirect('seller/products')->with('message', "Product $product->name berhasil di update");
    }

    public function destroy($id)
    {
        //
    }
}
