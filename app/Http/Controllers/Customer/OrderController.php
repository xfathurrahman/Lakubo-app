<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems')->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('customer.order.index',[
            'orders' => $orders,
        ]);
    }

    public function show($order_id)
    {
        $orders = Order::with('orderItems')->where('id', $order_id)->first();

        if ($orders->status === 'unpaid') {
            $snapToken = $this->getSnapToken($orders);

            return view('customer.order.show',[
                'snapToken' => $snapToken,
                'orders' => $orders,
            ]);
        }

        if ($orders->status === 'pending') {

            Config::$serverKey = config('midtrans.server_key');     // Set your Merchant Server Key
            Config::$isProduction = false;                              // Set to true for Production Environment.
            Config::$isSanitized = true;                                // Set sanitization on (default)
            Config::$is3ds = true;                                      // Set 3DS transaction for credit card to true

            $status = Transaction::status($orders->invoice);

            $status = json_decode(json_encode($status), true);

            $status->va_number            = $status['va_numbers'][0]['va_number'];
            $status->gross_amount         = $status['gross_amount'];
            $status->bank                 = $status['va_numbers'][0]['bank'];
            $status->transaction_status   = $status['transaction_status'];
            $transaction_time             = $status['transaction_time'];
            $status->deadline             = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));

            return view('customer.order.show',[
                'orders' => $orders,
                'status' => $status,
            ]);
        }

        return view('customer.order.show',[
            'orders' => $orders,
        ]);

    }

    public function getSnapToken($orders)
    {
        Config::$serverKey = config('midtrans.server_key');     // Set your Merchant Server Key
        Config::$isProduction = false;                              // Set to true for Production Environment.
        Config::$isSanitized = true;                                // Set sanitization on (default)
        Config::$is3ds = true;                                      // Set 3DS transaction for credit card to true

        $params = array(
            'transaction_details' => array(
                'order_id' => $orders->id,
                'gross_amount' => $orders->total_price + $orders->shipping,
            ),
            'customer_details' => array(
                'first_name' => '',
                'last_name' => $orders->customer_name,
                'email' => Auth::user()->email,
                'phone' => $orders->customer_phone,
            ),
        );
        return Snap::getSnapToken($params);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed === $request->signature_key)
        {
            $order = Order::find($request->order_id);
            $order->update(['status' => 'Paid']);
        }
    }

}
