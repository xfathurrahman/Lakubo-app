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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    /**
     * @throws ValidationException
     */
    public function update(Request $request, Store $store)
    {
        $data = $request->all();

        Validator::make($request->all(), [
            'nama_lapak' => ['required','string', 'max:255'],
            'kategori_lapak'=> ['required'],
            'deskripsi_lapak'=> ['required','string', 'max:255'],
            'kecamatan'=> ['required'],
            'desa'=> ['required'],
            'detail_alamat'=> ['required'],
        ])->validate();

        $store -> name = $data['nama_lapak'];
        $store -> category_id = $data['kategori_lapak'];
        $store -> description = $data['deskripsi_lapak'];
        $store->update();

        $storeAddress = StoreAddress::find($store->id);
        $storeAddress -> district_id = $data['kecamatan'];
        $storeAddress -> village_id = $data['desa'];
        $storeAddress -> detail_address = $data['detail_alamat'];
        $storeAddress -> embedded_map = $data['lokasi_di_map'];
        $storeAddress->update();

        return Redirect::route('seller.store.index')->with('status', 'store-updated');
    }

    public function destroy()
    {
        Auth::user()->stores->delete();
        Auth::user()->removeRole('seller');
        return Redirect::to('/');
    }

}
