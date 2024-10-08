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
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function edit(): Factory|View|RedirectResponse|Application
    {
        if (isset(Auth::user()->address)){
            $userAddress = Auth::user()->address;
            $provinces = Province::all();
            $regencies = Regency::where('province_id', $userAddress['province_id'])->get();
            $districts = District::where('regency_id', $userAddress['regency_id'])->get();
            $villages = Village::where('district_id', $userAddress['district_id'])->get();
            return view('profile.edit', [
                'provinces' => $provinces,
                'regencies' => $regencies,
                'districts' => $districts,
                'villages' => $villages,
            ]);
        }
        return redirect()->route('home')->with('error', 'Silahkan Login dulu.');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $province = $request-> input('provinsi');
        $regency = $request -> input('kabupaten');
        $district = $request-> input('kecamatan');
        $village = $request -> input('desa');
        $detail_address = $request-> input('detail_alamat');

        if (isset(Auth::user()->id)) {
            $request->user()->fill($request->validated());
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
        return redirect()->route('home')->with('error', 'Silahkan Login dulu.');
    }

    public function updateBankAccount(BankUpdateRequest $request)
    {
        $request->user()->fill($request->validated());
        $bank_acc_name = $request->input('bank_acc_name');
        $bank_acc_number = $request->input('bank_acc_number');
        $bank_name = $request->input('bank_name');
        $bank_info = User::where('id', Auth::id())->first();
        $bank_info -> bank_account_name = $bank_acc_name;
        $bank_info -> bank_account_number = $bank_acc_number;
        $bank_info -> bank_name = $bank_name;
        $bank_info -> update();
        return back()->with('status', 'bank-updated');
    }

    public function updatePhoto(Request $request)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $directory = public_path('/storage/profile-photos');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }
            $path = $directory.'/'.$name;
            Image::make($image->getRealPath())->resize(350, 350)->save($path);
            if ($user->image_path) {
                Storage::delete('public/storage/profile-photos/'.$user->profile_photo_path);
            }
            $user->profile_photo_path = $name;
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
