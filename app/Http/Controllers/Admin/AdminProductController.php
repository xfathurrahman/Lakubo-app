<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
