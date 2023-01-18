<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index() {
        $cartitems['cartitems'] = Cart::where('user_id', Auth::id())->get();
        $totalcart = Cart::where('user_id', Auth::id())->count();

        return view('home.pages.checkout')->with($cartitems)->with(['totalcart' => $totalcart]);
    }
}
