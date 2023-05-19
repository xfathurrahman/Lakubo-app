<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\OrderShipping;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index($cart_id)
    {
        if ($cart_id) {
            $cart = Cart::with('cartItems')->where('user_id', Auth::id())->where('id', $cart_id)->first();
            /*$services  = $this->getShippingCost($cart);
            if (empty($services)) {
                $errorMessage = "Maaf, tidak ada layanan pengiriman yang tersedia saat ini.";
                return view('home.pages.checkout', [
                    'cart'         => $cart,
                    'errorMessage' => $errorMessage,
                ]);
            }*/
            return view('home.pages.checkout', [
                'cart'     => $cart,
                /*'services' => $services,*/
            ]);
        }
        session()->flash('error', 'Anda belum memilih produk untuk di checkout, Anda dialihkan ke halaman keranjang.');
        return redirect()->route('customer.cart.index');
    }

    public function searchCityByName(string $searchQuery)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get(env('RAJAONGKIR_API_URL') . '/city', [
            'query' => $searchQuery
        ]);

        $cities = collect($response['rajaongkir']['results'])->map(function ($city) {
            return [
                'id'   => $city['city_id'],
                'name' => $city['city_name']
            ];
        });

        return $cities->pluck('id')->first();
    }

    public function getShippingCost(Request $request)
    {

        $shipping_agent = $request->input('shipping_agent');
        $cart_id = $request->input('cart_id');

        $cart = Cart::query()->find($cart_id);
        $totalWeight = 0;
        $subtotalWeight = 0;
        foreach ($cart->cartItems as $item) {
            $subtotalWeight += $item->products->weight * $item->product_qty;
        }

        $totalWeight += $subtotalWeight;
        $userAddress  = UserAddress::query()->find(Auth::id());
        $userRegency  = str_replace(array('KABUPATEN ', 'KOTA '), '', $userAddress->regency->name);
        $searchQuery  = $userRegency;
        $city         = $this->searchCityByName($searchQuery);
        $destination  = (int)$city;

        $cost = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->post(env('RAJAONGKIR_API_URL') . '/cost', [
            'origin'        => 91,              // ID kota/kabupaten asal // 91 adalah Boyolali
            'destination'   => $destination,    // ID kota/kabupaten tujuan
            'weight'        => $totalWeight,    // berat barang dalam gram
            'courier'       => $shipping_agent  // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ]);

        $services = [];
        if (isset($cost['rajaongkir']['status']['code']) && $cost['rajaongkir']['status']['code'] === 200) {
            foreach($cost['rajaongkir']['results'][0]['costs'] as $row) {
                $etd = $row['cost'][0]['etd'];
                if (str_contains($etd, 'HARI')) {
                    $etd = str_replace('HARI', '', $etd);
                }
                $services[] = array(
                    'description'   => $row['description'],
                    'shipping_cost' => $row['cost'][0]['value'],
                    'etd'           => $etd,
                );
            }
        }
        return $services;
    }

    public function store(Request $request, $cart_id)
    {
        // ambil data dari inputan
        $note = $request->input('note');
        $shipping_cost = $request->input('shipping_cost');
        $service = $request->input('service');
        $etd = $request->input('etd');

        // konfirgurasi midtrans
        Config::$serverKey = config('midtrans.server_key');         // Set your Merchant Server Key
        Config::$isProduction = config('midtrans.is_production');   // Set to true for Production Environment.
        Config::$isSanitized = true;                                    // Set sanitization on (default)
        Config::$is3ds = false;                                          // Set 3DS transaction for credit card to true

        // membuat order_id unik
        do {
            $order_id = strtoupper(random_int(10000, 99999));
            $orderExists = DB::table('orders')->where('id', $order_id)->exists();
        } while ($orderExists);

        $cart = Cart::with('cartItems')->where('user_id', Auth::id())->where('id', $cart_id)->first();
        // hitung total harga
        $totalPrice = 0;
        $subtotalPrice = 0;
        foreach ($cart->cartItems as $item) {
            $subtotalPrice += $item->products->price * $item->product_qty;
        }
        $totalPrice += $subtotalPrice;
        $grand_total =  $totalPrice + $shipping_cost;

        // generate snap token
        $params = array(
            'transaction_details' => array(
                'order_id' => $order_id,
                'gross_amount' => $grand_total,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'last_name' => '',
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ),
        );

        $snapToken = Snap::getSnapToken($params);

        // simpan data pesanan ke database
        try {
            $order = new Order;
            $order->id = $order_id;
            $order->user_id = Auth::id();
            $order->store_id = $cart->store_id;
            $order->snap_token = $snapToken;
            $order->customer_name = Auth::user()->name;
            $order->customer_phone = Auth::user()->phone;
            $order->customer_email = Auth::user()->email;
            $order->subtotal = $subtotalPrice;
            $order->grand_total = $grand_total;
            $order->note = $note;
            $order->save();

            $custAddress = Auth::user()->address;
            $orderAddress = new OrderAddress;
            $orderAddress->order_id = $order->id;
            $orderAddress->province_id = $custAddress->province_id;
            $orderAddress->regency_id = $custAddress->regency_id;
            $orderAddress->district_id = $custAddress->district_id;
            $orderAddress->village_id = $custAddress->village_id;
            $orderAddress->detail_address = $custAddress->detail_address;

            $orderItems = [];
            foreach ($cart->cartItems as $item) {
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->quantity = $item->product_qty;
                $subtotalPriceInput = $item->products->price * $item->product_qty;
                $orderItem->subtotal = $subtotalPriceInput;
                $orderItems[] = $orderItem;
            }

            $orderShipping = new OrderShipping;
            $orderShipping->shipping_cost = $shipping_cost;
            $orderShipping->service = $service;
            $orderShipping->etd = $etd;

            $order->orderAddress()->save($orderAddress);
            $order->orderShipping()->save($orderShipping);
            $order->orderItems()->saveMany($orderItems);

            $cart->delete();

            return redirect()->route('customer.order.show', ['order_id' => $order->id])->with('success', 'Pesanan berhasil dibuat!');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
