<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StoreCategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.store.index');
    }
}
