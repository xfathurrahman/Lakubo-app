<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\UserAddress;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $userAddresses['userAddresses'] = UserAddress::with('users')->where('user_id', $request->user()->id)->first();
        $address = UserAddress::with('users')->where('user_id', $request->user()->id)->first();
        $provinces = Province::all();
        $regencies = Regency::where('province_id', $address['province_id'])->get();
        $districts = District::where('regency_id', $address['regency_id'])->get();
        $villages = Village::where('district_id', $address['district_id'])->get();

        return view('profile.edit', [
                'user' => $request->user(),]
            ,compact('provinces','regencies','districts','villages'))->with($userAddresses);
    }

    public function getProvince()
    {
        $data = Province::where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
    }

    public function getRegency($id)
    {
        $data = Regency::where('province_id', $id)->where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
    }

    public function getDistrict($id)
    {
        $data = District::where('regency_id', $id)->where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
    }

    public function getVillage($id)
    {
        $data = Village::where('district_id', $id)->where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        $province = $request->province;
        $regency = $request->regency;
        $district = $request->district;
        $village = $request->village;
        $detail_address = $request->detail_address;

        $user_address = UserAddress::find(Auth::user()->id);
        $user_address -> province_id = $province;
        $user_address -> regency_id = $regency;
        $user_address -> district_id = $district;
        $user_address -> village_id = $village;
        $user_address -> detail_address = $detail_address;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user_address->update();

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $validator = $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
