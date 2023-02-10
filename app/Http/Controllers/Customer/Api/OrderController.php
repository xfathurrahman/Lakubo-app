<?php

namespace App\Http\Controllers\Customer\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @throws \JsonException
     */
    public function payment_handler(Request $request): string
    {
        $json = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);

        $serverKey = config('midtrans.server_key');
        $signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . $serverKey);
        if ($signature_key !== $json->signature_key) {
            return "This is invalid signature key";
        }
        // status berhasil
        return Order::where('id', $json->order_id)
            ->first()
            ->update(['transaction_status' => $json->transaction_status]);
    }
}
