<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function index()
    {
        /*$seller_id = Auth::user()->stores->id;
        $orders = Order::where('seller', $seller_id)->get();*/
        return view('seller.orders.index');
    }
}
