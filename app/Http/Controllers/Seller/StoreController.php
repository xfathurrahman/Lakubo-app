<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Store;
use App\Models\StoreAddress;
use App\Models\StoreCategory;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\BankUpdateRequest;

class StoreController extends Controller
{
    public function index()
    {
        $storeAddresses = StoreAddress::with('stores')->where('store_id',Auth::user()->stores->id)->first();
        $storeCategories = StoreCategory::all();
        $districts = District::where('regency_id', $storeAddresses->regency_id)->get();
        $villages = Village::where('district_id', $storeAddresses->district_id)->get();

        $countSuccessOrders = auth()->user()->stores->with(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])->get()->pluck('orders')->flatten()->count();

        return view('seller.store.index', compact('storeCategories','districts','villages','storeAddresses','countSuccessOrders'));
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

    public function updateBankAccount(BankUpdateRequest $request)
    {
        $request->user()->fill($request->validated());
        $bank_acc_name = $request->input('bank_acc_name');
        $bank_acc_number = $request->input('bank_acc_number');
        $bank_name = $request->input('bank_name');
        $bank_info = Store::where('id', Auth::user()->stores->id)->first();
        $bank_info -> bank_account_name = $bank_acc_name;
        $bank_info -> bank_account_number = $bank_acc_number;
        $bank_info -> bank_name = $bank_name;
        $bank_info -> update();
        return back()->with('status', 'bank-updated');
    }

    public function destroy()
    {
        Auth::user()->stores->delete();
        Auth::user()->removeRole('seller');
        return Redirect::to('/');
    }

}
