<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Village;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return view('auth.register',compact('provinces'));
    }

    public function getKabupaten(Request $request)
    {
        $id_provinsi = $request->id_provinsi;
        $kabupatens = Regency::where('province_id', $id_provinsi)->get();
        $option = "<option value='' selected disabled>-- Pilih Kabupaten --</option>";
        foreach ($kabupatens as $kabupaten){
            $option .= "<option value='$kabupaten->id'>$kabupaten->name</option>";
        }
        echo $option;
    }

    public function getKecamatan(Request $request)
    {
        $id_kabupatens = $request->id_kabupaten;
        $kecamatans = District::where('regency_id', $id_kabupatens)->get();
        $option = "<option value='' selected disabled>-- Pilih Kecamatan --</option>";
        foreach ($kecamatans as $kecamatan){
            $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
        }
        echo $option;
    }

    public function getDesa(Request $request)
    {
        $id_kecamatans = $request->id_kecamatan;
        $desas = Village::where('district_id', $id_kecamatans)->get();
        $option = "<option value='' selected disabled>-- Pilih Desa --</option>";
        foreach ($desas as $desa){
            $option .= "<option value='$desa->id'>$desa->name</option>";
        }
        echo $option;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:13'],
            'password' => ['required'],
        ]);

        $data = $request->all();
        /*dd($data);*/
        $user = new User;
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = Hash::make($data['password']);
        $user->assignRole('customer')->save();

        $user_address = new UserAddress;
        $user_address->user_id = $user->id;
        $user_address->province_id = $data['province'];
        $user_address->regency_id = $data['regency'];
        $user_address->district_id = $data['district'];
        $user_address->village_id = $data['village'];
        $user_address->detail_address = $data['detail_address'];
        $user_address->save();

        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
