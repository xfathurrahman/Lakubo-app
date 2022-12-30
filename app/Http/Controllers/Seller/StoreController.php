<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Store;
use App\Models\StoreAddress;
use App\Models\StoreCategory;
use App\Models\UserAddress;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StoreController extends Controller
{
    public function index()
    {
        $storeAddresses = StoreAddress::with('stores')->where('store_id',Auth::user()->stores->id)->first();
        $storeCategories = StoreCategory::all();
        $districts = District::where('regency_id', $storeAddresses->regency_id)->get();
        $villages = Village::where('district_id', $storeAddresses->district_id)->get();

        return view('seller.store.index', compact('storeCategories','districts','villages','storeAddresses'));
    }

    public function destroy()
    {
        Auth::user()->stores->delete();
        Auth::user()->removeRole('seller');
        return Redirect::to('/');
    }

}
