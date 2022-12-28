<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index()
    {

        $store = Store::where('user_id', auth()->user()->id)->get();

        if ($store == ''){
            return back()->with('error','Anda belum memiliki Lapak UMKM');
        }

        return view('seller.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
