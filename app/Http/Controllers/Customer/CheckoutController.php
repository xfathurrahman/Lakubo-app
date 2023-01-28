<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Province;
use App\Models\StoreAddress;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckoutController extends Controller
{
    public function index($id) {

        $uid = Auth::id();

        $cartItems = CartItem::where('user_id', $uid)->where('cart_id', $id)->get();
        if ($cartItems->count() < 1) {
            session()->flash('error', 'Anda belum bisa checkout, \n Anda di alihkan ke halaman keranjang.');
            return redirect('customer/cart');
        }

        $totalWeight = 0;
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->products->price * $item->product_qty;
            $totalWeight += $item -> products -> weight;
        }

        $userAddress = UserAddress::find($uid);
        $userRegency = $userAddress->regency->name; // Get kota user

        $regency = RajaOngkir::kota()->search($userRegency)->get();
        $regency_id = $regency[0]['city_id'];

        $cost = RajaOngkir::ongkosKirim([
            'origin'        => 91,     // ID kota/kabupaten asal // 91 adalah Boyolali
            'destination'   => $regency_id,      // ID kota/kabupaten tujuan
            'weight'        => $totalWeight,    // berat barang dalam gram
            'courier'       => 'jne'    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        $services = [];

        foreach($cost[0]['costs'] as $row) {
            $services[] = array(
              'description'     => $row['description'],
              'biaya'     => $row['cost'][0]['value'],
              'etd'     => $row['cost'][0]['etd'],
            );
        }

        return view('home.pages.checkout',compact('cartItems','services'));
    }
}
