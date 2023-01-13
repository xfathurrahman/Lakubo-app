<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartitems['cartitems'] = Cart::where('user_id', Auth::id())->get();
        $totalcart = Cart::where('user_id', Auth::id())->count();

        return view('home.pages.cart')->with($cartitems)->with(['totalcart' => $totalcart]);
    }

    public function addProductToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');

        if (Auth::check())
        {
            $prod_check = Product::where('id',$product_id)->first();

            if($prod_check)
            {
                if (Cart::where('product_id',$product_id)->where('user_id',Auth::id())->exists())
                {
                    return response()->json(['error' => "<p style='color: #ff5959'>" .$prod_check-> name.'</p>sudah ada di keranjang']);
                }
                $cartItem = new Cart();
                $cartItem -> product_id = $product_id;
                $cartItem -> user_id = Auth::id();
                $cartItem -> product_qty = $product_qty;
                $cartItem -> save();

                return response()->json(['success' => $prod_check-> name." ditambahkan ke keranjang"]);
            }
        }
        else
        {
            return response()->json(['error'=>"Silahkan Login dulu untuk belanja :)"]);
        }
    }

    public function deleteCartItem(Request $request)
    {
        if(Auth::check())
        {
            $product_id = $request->input('prod_id');
            if(Cart::where('product_id', $product_id)->where('user_id',Auth::id())->first())
            {
                $cartItem = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();
                $cartItem->delete();
                return response()->json(['status' => "Produk dihapus dari keranjang"]);
            }
        }
        else
        {
            return response()->json(['status' => "Silahkan login dulu untuk belanja"]);
        }
    }

    public function updateCartItem(Request $request)
    {
        $product_id = $request->input('prod_id');
        $product_qty = $request->input('prod_qty');

        if(Auth::check())
        {
            if(Cart::where('product_id', $product_id)->where('user_id',Auth::id())->exists())
            {
                $cartItem = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();
                $cartItem -> product_qty = $product_qty;
                $cartItem->update();

                return response()->json(['status' => "Kuantitas di ubah"]);
            }
        }
        else
        {
            return response()->json(['status' => "Silahkan login dulu untuk belanja"]);
        }

    }

    public function cartCount(){

        $cartcount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'count' => $cartcount
        ]);

    }

}
