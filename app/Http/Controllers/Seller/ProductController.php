<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\StoreProductRequest;
use App\Http\Requests\Seller\UpdateProductRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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

            return view('seller.products.index', [
                'listProducts' => $listProducts->appends(request()->query()),
                'simplePagination' => true // Menandakan penggunaan pagination sederhana
            ]);
        }
        return view('seller.products.index');
    }

    public function create()
    {
        $listCateProd = ProductCategory::all();
        return view('seller.products.create', compact('listCateProd'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->all();
        $request->validated();

        $product = new Product;
        $product->name = $data['nama_produk'];
        $product->price = $data['harga'];
        $product->category_id = $data['kategori'];
        $product->description = $data['deskripsi'];
        $product->quantity = $data['stok'];
        $product->weight = $data['berat'];
        $product->store_id = Auth::user()->stores->id;
        $product->save();

        if ($request->hasfile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $image = new ProductImage();
                $image_name = time().'-'.preg_replace('~[\\\\/:*?"<>|& ]~', '', $file->getClientOriginalName());
                $directory = public_path('/storage/product-images');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                $path = $directory.'/'.$image_name;
                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(350, 350);
                $image_resize->save($path);
                $image->product_id = $product->id;
                $image->image_path = $image_name;
                $image->save();
            }
        }

        $action  = $request->input('action');

        if ($action === 'save_and_new') {
            return back()->with("success", "Produk berhasil ditambahkan");
        }

        return redirect()->route('seller.products.index')->with("success", "Produk berhasil ditambahkan");
    }


    public function show($id)
    {
        // return view('seller.products.detail');
    }

    public function edit(Product $product)
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

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();
        $request->validated();

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
                    $image_name = time().'-'.preg_replace('~[\\\\/:*?"<>|& ]~', '', $file->getClientOriginalName());
                    $directory = public_path('/storage/product-images');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }
                    $path = $directory.'/'.$image_name;
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->resize(350, 350);
                    $image_resize->save($path);
                    $image->product_id = $product->id;
                    $image->image_path = $image_name;
                    $image->save();
                }
            }
            $product -> name = $data['nama_produk'];
            $product -> price = $data['harga'];
            $product -> category_id = $data['kategori'];
            $product -> description =  $data['deskripsi'];
            $product -> quantity =  $data['stok'];
            $product -> weight =  $data['berat'];
            $product->update();

            return redirect('seller/products')->with('success', "Product $product->name berhasil di update");
        }
        return back()->with('error','Wajib menggunggah minimal 1 gambar produk.');
    }

    public function destroy($product) {
        $product = Product::query()->find($product);

        if ($product) {
            // Memeriksa apakah ada order_item terkait dengan produk ini
            $hasOrders = OrderItem::query()->where('product_id', $product->id)->exists();

            if ($hasOrders) {
                return redirect('seller/products')->with('error', 'Produk sedang dalam transaksi.');
            }

            foreach ($product->productImages as $image) {
                $path = public_path('storage/product-images/'.$image->image_path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $product->productImages()->delete();
            $product->delete();
            return redirect('seller/products')->with('success', 'Produk berhasil dihapus.');
        }

        return redirect('seller/products')->with('success', 'Produk tidak ditemukan.');
    }

}
