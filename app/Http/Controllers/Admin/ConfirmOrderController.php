<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Models\Order;
use App\Models\StoreTransaction;
use Carbon\Carbon;

class ConfirmOrderController extends Controller
{
    public function index()
    {
        $ordersToShow = [];

        $orders = Order::with('orderShipping')->where('status', 'delivered')->get();

        foreach ($orders as $order) {
            if ($order->orderShipping) {
                $shipping_at = Carbon::parse($order->orderShipping->shipping_at);
                $etd = $order->orderShipping->etd;

                if (strpos($etd, '-') !== false) {
                    // Jika etd berisi rentang angka (misal: "3-6")
                    $etd = explode('-', $etd)[1];
                }

                $estimatedDelivery = $shipping_at->copy()->addDays($etd);
                $maxDeliveryDate = $estimatedDelivery->copy()->addDays(3);

                if ($maxDeliveryDate->isPast()) {
                    // Tambahkan order yang estimasinya + 3 hari sudah lewat ke array $ordersToShow
                    $ordersToShow[] = $order;
                }
            }
        }

        return view('admin.confirm.index', [
            'orders' => $ordersToShow,
        ]);
    }


    public function confirmOrder($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);
            $order->status = 'completed';
            $order->save();

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

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengkonfirmasi pesanan.'
            ], 500);
        }
    }

}
