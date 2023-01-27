<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{



    public function index($id) {

        $cartName = Cart::find($id);
        $cartItems = CartItem::where('cart_id', $id)->get();

        return view('home.pages.checkout',compact('cartItems','cartName'));
    }
}
