<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function payment_handler(Request $request): void
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed === $request->signature_key) {
            if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement'){
                $order = Order::find($request->order_id);

                // mengurangi stok produk terkait
                foreach($order->orderItems as $order_item) {
                    $product = Product::find($order_item->product_id);
                    $product->stock -= $order_item->quantity;
                    $product->save();
                }

                // mengupdate status order
                $order->update([
                    'transaction_status' => 'completed',
                    'status' => 'awaiting_confirm',
                    'transaction_time' => $request->transaction_time,
                    'transaction_id' => $request->transaction_id,
                    'payment_type' => $request->payment_type ?? null,
                    'va_number' => $request->va_numbers[0]['va_number'] ?? null,
                    'bank' => $request->va_numbers[0]['bank'] ?? null,
                ]);
            }
            if ($request->transaction_status === 'cancel' || $request->transaction_status === 'deny' || $request->transaction_status === 'expire'){
                $order = Order::find($request->order_id);
                $order->update([
                    'transaction_status' => 'cancel',
                    'status' => 'cancelled'
                ]);
            }
        }
    }
}
