<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Province;
use App\Models\Regency;
use App\Models\StoreAddress;
use App\Models\Village;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        $categories = ProductCategory::orderBy('id', 'asc')->get();

        return view('home.pages.index', compact('products','categories'));
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        $images = ProductImage::where('product_id',$id)
            ->orderBy('id','asc')
            ->get();

        $storeAddresses = StoreAddress::where('store_id', Auth::user()->stores->id)->first();

        $province = Province::find('33');
        $regency = Regency::find('3309');
        $district = District::where('regency_id', $storeAddresses->regency_id )->first();
        $village = Village::where('district_id', $storeAddresses->district_id)->first();

        return view('home.pages.product-detail', compact
        (
            'product','images', 'province', 'regency', 'district', 'village'
        ));
    }

}
