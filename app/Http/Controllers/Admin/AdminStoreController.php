<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;

class AdminStoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('users','products','storeCategories')
            ->Paginate(10)
            ->onEachSide(2);

        return view('admin.store.index', compact('stores'));
    }
}
