<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $userCarts = Cart::with('cartItems')->where('user_id', $userId)->get();
        return view('home.pages.cart', [
            'userCarts' => $userCarts,
        ]);
    }

    public function addProductToCart(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $product_id = $request->input('product_id');
        $store_id = $request->input('store_id');
        $qty = $request->input('qty');

        $cart = Cart::where('user_id', $userId)->where('store_id', $store_id)->first();
        $cartItem = CartItem::where('user_id', $userId)->where('product_id', $product_id)->first();

        if (Auth::check()) {
            if (!$cart) {
                $cart = new Cart();
                $cart -> user_id = $userId;
                $cart -> store_id = $store_id;
                $cart -> save();
            } elseif ($cartItem) {
                return response()->json(['error' => "<p style='color: #ff5959'>" . $cartItem->name . '</p>sudah ada di keranjang']);
            }
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->user_id = $userId;
            $cartItem->product_id = $product_id;
            $cartItem -> product_qty = $qty;
            $cartItem->save();
            return response()->json(['success' => "ditambahkan ke keranjang"]);
        }
        return response()->json(['status' => "Silahkan login dulu untuk belanja"]);
    }

    public function deleteCartItem(Request $request)
    {
        $product_id = $request->input('prod_id');
        if(Auth::check())
        {
            $cartItem = CartItem::where('product_id', $product_id)->first();
            if ($cartItem) {
                $countItem = CartItem::where('cart_id', $cartItem->cart_id)->count();
                if ($countItem === 1) {
                    $carts = Cart::find($cartItem->cart_id);
                    $carts->delete();
                }
            }
            $cartItem -> delete();
            /*$carts = Cart::where('user_id',Auth::id())->first();
            $cartItem = CartItem::where('product_id', $product_id)->where('user_id',Auth::id())->first();

            if ($cartItem->count() > 1) {
                $cartItem->delete();
            }
            $cartItem->delete();

            if ($carts -> cartItems -> count() === 0 ) {
                $carts -> delete();
            }*/
        }
    }

    public function updateCartItem(Request $request)
    {
        $product_id = $request->input('prod_id');
        $product_qty = $request->input('prod_qty');

        if(Auth::check() && CartItem::where('product_id', $product_id)->where('user_id', Auth::id())->exists()) {
            $cartItem = CartItem::where('product_id', $product_id)->where('user_id', Auth::id())->first();
            $cartItem -> product_qty = $product_qty;
            $cartItem->update();
            return response()->json(['status' => "Kuantitas di ubah"]);
        }
    }

    public function cartCount(){
        $cartcount = CartItem::where('user_id', Auth::id())->count();
        return response()->json([
            'count' => $cartcount
        ]);
    }

}
