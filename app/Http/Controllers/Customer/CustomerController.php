<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateStoreRequest;
use App\Models\District;
use App\Models\Store;
use App\Models\StoreAddress;
use App\Models\StoreCategory;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.store.index');
    }

    public function create()
    {
        return view('customer.store.create');
    }

    public function getDistrict()
    {
        $data = District::where('regency_id', 3309)->where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
    }

    public function getStoreCate()
    {
        $data = StoreCategory::where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
    }

    public function store(CreateStoreRequest $request)
    {
        $data = $request->all();
        $request->validated();

        $store = new Store();
        $store->user_id = Auth::user()->id;
        $store->name = $data['nama'];
        $store->category_id = $data['kategori'];
        $store->description = $data['deskripsi'];
        $store->save();

        $storeAddress = new StoreAddress();
        $storeAddress->store_id = $store->id;
        $storeAddress->province_id = 33;
        $storeAddress->regency_id = 3309;
        $storeAddress->district_id = $data['kecamatan'];
        $storeAddress->village_id = $data['desa'];
        $storeAddress->detail_address = $data['detail_alamat'];
        $storeAddress->embedded_map = $data['google_maps'];
        $storeAddress->save();

        Auth::user()->assignRole('seller');

        return redirect('seller/dashboard')->with('success','Berhasil membuat lapak UMKM');
    }
}
