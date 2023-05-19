<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Store;
use App\Models\StoreAddress;
use App\Models\Village;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(): Factory|View|Application
    {
        $products = Product::query()->orderBy('id', 'desc')->get();
        $categories = ProductCategory::query()->orderBy('id', 'asc')->get();

        return view('home.pages.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function termAndConditions(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('home.pages.term-and-conditions');
    }

    public function privacyPolicy(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('home.pages.privacy-policy');
    }

    public function getProduct($id): Factory|View|Application
    {
        $product = Product::query()->find($id);
        $images = ProductImage::query()->where('product_id',$id)->orderBy('id','asc')->get();
        $province = ucwords(strtolower(Province::find('33')->name));
        $regency = ucwords(strtolower(Regency::find('3309')->name));
        $district = ucwords(strtolower(District::where('regency_id', $product->stores->storeAddresses->regency_id )->first()->name));
        $village = ucwords(strtolower(Village::where('district_id', $product->stores->storeAddresses->district_id)->first()->name));
        $detail_address = ucwords(strtolower($product->stores->storeAddresses->detail_address));

        return view('home.pages.product-details', [
            'product' => $product,
            'images' => $images,
            'province' => $province,
            'regency' => $regency,
            'district' => $district,
            'village' => $village,
            'detail_address' => $detail_address,
        ]);
    }

    public function getProductByCategory($id): Factory|View|Application
    {
        $products = Product::query()->where('category_id', $id)->orderBy('created_at', 'DESC')->paginate(16);
        $productsCategory = ProductCategory::query()->find($id)->name;

        return view('home.pages.category-detail', [
            'products' => $products,
            'productsCategoryName' => $productsCategory,
        ]);
    }

    public function getNewProduct(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $products = Product::query()->orderBy('created_at', 'DESC')->paginate(16);
        return view('home.pages.new-products', [
            'products' => $products,
        ]);
    }

    public function searchProduct(Request $request)
    {
        $query = $request->query('query');
        $category = $request->query('category');

        if (empty($category) || $category === "undefined") {
            $products = Product::query()->where('name', 'LIKE', '%'.$query.'%')->get();
        } else {
            $products = Product::query()->where('category_id', $category)->where('name', 'LIKE', '%'.$query.'%')->get();
        }

        return response()->json($products);
    }

    public function searchResult(Request $request)
    {
        $query = $request->query('query');
        $category = $request->query('category');
        $error = $request->input('error');

        if (empty($category) || $category === "undefined") {
            $products = Product::query()->where('name', 'LIKE', '%'.$query.'%')->get();
        } else {
            $products = Product::query()->where('category_id', $category)->where('name', 'LIKE', '%'.$query.'%')->get();
        }

        $searchTerm = $query;
        $category = ProductCategory::query()->find($category);

        return view('home.pages.search-results', [
            'products' => $products,
            'searchTerm' => $searchTerm,
            'category' => $category,
            'error' => $error,
        ]);
    }

    public function getStoreDetail($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $store = Store::query()->find($id);
        $storeProducts = Product::query()->where('store_id', $id)->paginate(16);

        $countSuccessOrders = $store->with(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])->get()->pluck('orders')->flatten()->count();

        return view('home.pages.store-details', [
            'store' => $store,
            'storeProducts' => $storeProducts,
            'countSuccessOrders' => $countSuccessOrders,
        ]);
    }

}
