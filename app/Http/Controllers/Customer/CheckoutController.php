<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index($store_id) {

        $cartItems = $this->getCartItems($store_id);
        $services  = $this->getShippingCost($cartItems);

        return view('home.pages.checkout', [
            'cartItems' => $cartItems,
            'services' => $services,
        ]);
    }

    public function getCartItems($store_id) {
        $cartItems = CartItem::where('user_id', Auth::id())->where('cart_id', $store_id)->get();
        if ($cartItems->count() < 1) {
            session()->flash('error', 'Anda belum bisa checkout, \n Anda di alihkan ke halaman keranjang.');
            return redirect('customer/cart');
        }

        return $cartItems;
    }

    public function getShippingCost($cartItems): array
    {
        $totalWeight = 0;
        $subtotalWeight = 0;
        foreach ($cartItems as $item) {
            $subtotalWeight += $item -> products -> weight * $item->product_qty;
        }
        $totalWeight += $subtotalWeight;

        $userAddress = UserAddress::find(Auth::id());
        $userRegency = $userAddress->regency->name;
        $regency = RajaOngkir::kota()->search($userRegency)->get();
        $regency_id = $regency[0]['city_id'];

        $cost = RajaOngkir::ongkosKirim([
            'origin'        => 91,              // ID kota/kabupaten asal // 91 adalah Boyolali
            'destination'   => $regency_id,     // ID kota/kabupaten tujuan
            'weight'        => $totalWeight,    // berat barang dalam gram
            'courier'       => 'jne'            // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        $services = [];
        foreach($cost[0]['costs'] as $row) {
            $services[] = array(
                'description'   => $row['description'],
                'biaya'         => $row['cost'][0]['value'],
                'etd'           => $row['cost'][0]['etd'],
            );
        }
        return $services;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request, $store_id)
    {
        $cartItems = $this->getCartItems($store_id);
        $totalPrice = 0;
        $subtotalPrice = 0;
        foreach ($cartItems as $item) {
            $subtotalPrice += $item -> products -> price * $item->product_qty;
        }
        $totalPrice += $subtotalPrice;
        $shippingCost = $request->input('shipping');
        $note = $request->input('note');

        $order = new Order;
        do {
            $invoice = "INV/".strtoupper(random_int(1000000, 9999999));
            $invoiceExists = DB::table('orders')->where('invoice', $invoice)->exists();
        } while ($invoiceExists);
        $order->invoice = $invoice;
        $order -> user_id = Auth::id();
        $order -> customer_name = Auth::user()->name;
        $order -> customer_phone = Auth::user()->phone;
        $order -> shipping = $shippingCost;
        $order -> note = $note;
        $order -> total_price = $totalPrice;
        $order->save();

        foreach ($cartItems as $item) {
            $orderItem = new OrderItem;
            $orderItem -> order_id = $order->id;
            $orderItem -> product_id = $item->product_id;
            $orderItem -> quantity = $item->product_qty;
            $subtotalPriceInput = $item -> products -> price * $item->product_qty;
            $orderItem -> subtotal = $subtotalPriceInput;
            $orderItem -> save();
        }

        $custAddress = Auth::user()->address;
        $orderAddress = new OrderAddress;
        $orderAddress -> order_id = $order->id;
        $orderAddress -> province_id = $custAddress->province_id;
        $orderAddress -> regency_id = $custAddress->regency_id;
        $orderAddress -> district_id = $custAddress->district_id;
        $orderAddress -> village_id = $custAddress->village_id;
        $orderAddress -> detail_address = $custAddress->detail_address;
        $orderAddress->save();

        return redirect()->route('customer.order.show', ['order_id' => $order->id])->with('success', 'Pesanan berhasil dibuat!');
    }

}
