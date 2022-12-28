<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class IndoRegionController extends Controller
{
    public function getBoyolali()
    {
        $data = District::where('regency_id', 3309)->where('name', 'LIKE', '%'.request('q').'%')->paginate(100);
        return response()->json($data);
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
}
