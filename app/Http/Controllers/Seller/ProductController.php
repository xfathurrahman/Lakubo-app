<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        /*$store_id = Store::with('users')->where('store_id',Auth::user()->id)->get();*/

        $listProducts = Product::with('categories','productImages','users')
            ->where('user_id', Auth::user()->id)
            ->Paginate(10)
            ->onEachSide(2);

        return view('seller.products.index', compact('listProducts'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'name'=>'required|string',
            'category_id'=>'required',
            'quantity'=>'required',
            'description'=>'required|string',
            'files' => 'required',
        ])->validate();

        $name=$request->name;
        $price=$request->price;
        $category_id=$request->category_id;
        $description=$request->description;
        $quantity=$request->quantity;

        $product  = new Product;
        $product -> name=$name;
        $product -> price=$price;
        $product -> category_id=$category_id;
        $product -> description=$description;
        $product -> quantity=$quantity;
        $product -> user_id=Auth::user()->id;
        $product -> save();

        $productId=$product->id;

        if ($request->hasfile('files')) {
            $files = $request->file('files');
            foreach($files as $file) {
                $image  = new ProductImage;
                $name   = time().'.'.$file->getClientOriginalName();
                $path   = public_path('/storage/product-image');
                $file  -> move($path, $name);
                $image -> product_id=$productId;
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
        return view('seller.products.edit', compact( 'product'));
    }

    public function update(Request $request, Product $product)
    {
        Validator::make($request->all(), [
            'name'=>'required',
            'category_id'=>'required',
            'quantity'=>'required',
            'description'=>'required',
        ])->validate();

        $name=$request->name;
        $price=$request->price;
        $category_id=$request->category_id;
        $description=$request->description;
        $quantity=$request->quantity;

        // nambah foto baru
        if ($request->hasfile('files')) {
            // hapus image_path dari DB
            $imagedel = ProductImage::with('products')->where('product_id', $product->id);
            $imagedel ->delete();

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
        $product -> name = $name;
        $product -> price = $price;
        $product -> category_id = $category_id;
        $product -> description = $description;
        $product -> quantity = $quantity;
        $product -> user_id = Auth::user()->id;
        $product->update();
        return redirect('seller/products')->with('message', "Product $product->name berhasil di update");
    }

    public function destroy($id)
    {
        //
    }
}
