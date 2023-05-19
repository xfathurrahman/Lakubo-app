<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productCategories','productImages','stores')
            ->Paginate(10)
            ->onEachSide(2);
        return view('admin.product.index', compact('products'));
    }

    public function destroy($product) {
        $product = Product::query()->find($product);

        if ($product) {
            // Memeriksa apakah ada order_item terkait dengan produk ini
            $hasOrders = OrderItem::query()->where('product_id', $product->id)->exists();

            if ($hasOrders) {
                return redirect('admin/products')->with('error', 'Produk sedang dalam transaksi.');
            }

            foreach ($product->productImages as $image) {
                $path = public_path('storage/product-images/'.$image->image_path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $product->productImages()->delete();
            $product->delete();
            return redirect('admin/products')->with('success', 'Produk berhasil dihapus.');
        }

        return redirect('admin/products')->with('success', 'Produk tidak ditemukan.');
    }
}
