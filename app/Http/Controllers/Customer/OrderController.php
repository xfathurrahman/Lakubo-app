<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StoreTransaction;
use App\Models\UserTransaction;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil status yang dipilih dari request, atau defaultnya adalah null
        $status = $request->input('status', null);

        // Membuat query builder untuk model Order dengan filter status
        $query = Order::with('orderItems')->where('user_id', Auth::id())
            // ->whereNotNull('status')
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
        $barcodeUrl = "https://api.midtrans.com/v2/qris/$order->transaction_id/qr-code";
        return view('customer.order.show',[
            'order' => $order,
            'barcodeUrl' => $barcodeUrl
        ]);
    }

    /**
     * @throws JsonException
     */
    public function update(Request $request, $order_id)
    {
        $order = Order::query()->find($order_id);
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
            if ($json->payment_type === 'bank_transfer') {
                // add 24 hours (1 day) if payment_type is bank_transfer
                $expiry_time->add(new DateInterval('P1D'));
            } else {
                // add 15 minutes if payment_type is not bank_transfer
                $expiry_time->add(new DateInterval('PT15M'));
            }
            $order->transaction_expire = $expiry_time->format('Y-m-d H:i:s');
            $va_number = $json->va_numbers[0]->va_number ?? null;
            $order->va_number = $va_number;
            $bank = $json->va_numbers[0]->bank ?? null;
            $order->bank = $bank;
            $order->pdf_url = $json->pdf_url ?? null;
            $order->update();

            UserTransaction::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'amount' => $order->grand_total,
                'payment_method' => $json->payment_type ?? null,
                'payment_type' => 'purchase',
            ]);

            $cart = session()->get('cart');

            return redirect()->back()->with('success', 'Pembayaran berhasil');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirmOrder($order_id): RedirectResponse
    {
        // Ubah status order menjadi completed
        $order = Order::query()->find($order_id);
        $order->status = 'completed';
        $order->update();

        // Tambahkan grand total ke saldo toko
        $store = $order->stores;
        $store->balance += $order->grand_total;
        $store->update();

        // Tambahkan transaksi ke store transaction
        StoreTransaction::create([
            'store_id' => $order->stores->id,
            'order_id' => $order->id,
            'amount' => $order->grand_total,
            'payment_method' => $order->payment_type ?? null,
            'payment_type' => 'selling',
        ]);

        // Simpan data session pada controller
        session()->flash('message');
        return redirect()->route('customer.orders');
    }

}
