<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        $province = $request-> provinsi;
        $regency = $request -> kabupaten;
        $district = $request-> kecamatan;
        $village = $request -> desa;
        $detail_address = $request->detail_alamat;

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

    public function updateBankAccount(BankUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        $bank_info = User::where('id', Auth::id())->first();

        $bank_acc_name = $request->input('bank_acc_name');
        $bank_acc_number = $request->input('bank_acc_number');
        $bank_name = $request->input('bank_name');

        $bank_info -> bank_account_name = $bank_acc_name;
        $bank_info -> bank_account_number = $bank_acc_number;
        $bank_info -> bank_name = $bank_name;
        $bank_info -> update();

        return back()->with('status', 'bank-updated');
    }

    public function updatePhoto(Request $request)
    {

        $user = User::find(Auth::id());

        if($request->hasFile('profile_photo'))
        {
            if ($user->profile_photo_path) {

                $path = public_path('storage/profile-photos/'.$user->profile_photo_path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $file = $request ->file('profile_photo');
            $image_name = preg_replace('~[\\\\/:*?"<>|& ]~', '', $file->getClientOriginalName());
            $fileName = date('mYdhs').'_'.$image_name;
            $path   = public_path('/storage/profile-photos');
            $file  -> move($path, $fileName);
            $user->profile_photo_path = $fileName;
            $user->update();

            return response()->json(['message' => 'Success to update profile photo']);
        }
        return response()->json(['message' => 'Failed to update profile photo']);
    }

    public function destroyPhoto()
    {
        $user = User::find(Auth::id());
        if ($user->profile_photo_path)
        {
            $path = public_path('storage/profile-photos/'.$user->profile_photo_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $user -> profile_photo_path = null;
            $user -> save();

            return response()->json(['message' => 'Success to delete profile photo']);
        }
        return response()->json(['message' => 'Photo already Empty']);
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
