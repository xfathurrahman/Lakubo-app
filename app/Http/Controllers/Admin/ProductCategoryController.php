<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.product.index');
    }
}
