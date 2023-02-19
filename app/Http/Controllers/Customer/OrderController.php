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
    public function index(Request $request)
    {
        // Mengambil status yang dipilih dari request, atau defaultnya adalah null
        $status = $request->input('status', null);

        // Membuat query builder untuk model Order dengan filter status
        $query = Order::with('orderItems')->where('user_id', Auth::id())
            ->whereNotNull('status')
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        // Mengambil data orders yang sudah difilter
        $orders = $query->get();

        // Jika request merupakan ajax, maka hanya akan merespon dengan data tabel saja
        if ($request->ajax()) {
            return view('customer.order.partials.orders_table', [
                'orders' => $orders,
            ])->render();
        }

        // Jika request bukan ajax, maka akan merespon dengan halaman lengkap
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
            if ($json->transaction_status === 'pending') {
                $order->transaction_status = 'awaiting_payment';
            } else {
                $order->transaction_status = $json->transaction_status;
            }
            $order->transaction_id = $json->transaction_id ?? null;
            $order->status = 'awaiting_payment';
            $order->payment_type = $json->payment_type ?? null;
            $order->payment_code = $json->payment_code ?? null;
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

    public function confirmOrder($order_id) {
        $order = Order::find($order_id);
        $order -> status = 'completed';
        $order -> update();
        return redirect()->route('customer.orders')->with('success');
    }

}
