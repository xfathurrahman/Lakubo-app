<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JsonException;
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
        $order = Order::with('orderItems')->where('id', $order_id)->first();

        return view('customer.order.show',[
            'order' => $order,
        ]);
    }

    /**
     * @throws JsonException
     */
    public function update(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $json = json_decode($request->get('json'), false, 512, JSON_THROW_ON_ERROR);

        try {
            $order->transaction_id = $json->transaction_id ?? null;
            $order->transaction_status = $json->transaction_status;
            $order->payment_type = $json->payment_type ?? null;
            $order->payment_code = $json->payment_code ?? null;
            $order->payment_store = $json->store ?? null;
            $transaction_time = $json->transaction_time ?? null;
            $order->transaction_time = $transaction_time;
            $expiry_time = new DateTime($transaction_time);
            $expiry_time->add(new DateInterval('P1D'));
            $order->transaction_expire = $expiry_time->format('Y-m-d H:i:s');
            $va_number = $json->va_numbers[0]->va_number ?? null;
            $order->va_number = $va_number;
            $bank = $json->va_numbers[0]->bank ?? null;
            $order->bank = $bank;
            $order->pdf_url = $json->pdf_url ?? null;
            $order->update();

            return redirect()->back()->with('success', 'Pembayaran berhasil');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
