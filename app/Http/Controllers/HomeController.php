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
    public function index(): Factory|View|Application
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        $categories = ProductCategory::orderBy('id', 'asc')->get();

        return view('home.pages.index', compact('products','categories'));
    }

    public function getProduct($id): Factory|View|Application
    {
        $product = Product::find($id);
        $images = ProductImage::where('product_id',$id)->orderBy('id','asc')->get();
        $province = ucwords(strtolower(Province::find('33')->name));
        $regency = ucwords(strtolower(Regency::find('3309')->name));
        $district = ucwords(strtolower(District::where('regency_id', $product->stores->storeAddresses->regency_id )->first()->name));
        $village = ucwords(strtolower(Village::where('district_id', $product->stores->storeAddresses->district_id)->first()->name));
        $detail_address = ucwords(strtolower($product->stores->storeAddresses->detail_address));

        return view('home.pages.product-detail', [
            'product' => $product,
            'images' => $images,
            'province' => $province,
            'regency' => $regency,
            'district' => $district,
            'village' => $village,
            'detail_address' => $detail_address,
        ]);
    }

}
