<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $seller_id = auth()->user()->id;

        // Mengambil status yang dipilih dari request, atau defaultnya adalah null
        $status = $request->input('status', null);

        // Membuat query builder untuk model Order dengan filter status
        $query = Order::where('store_id', $seller_id)
            ->whereNotNull('status')
            ->orderBy('created_at', 'asc');

        if ($status) {
            $query->where('status', $status);
        }

        // Mengambil data orders yang sudah difilter
        $orders = $query->get();

        // Jika request merupakan ajax, maka hanya akan merespon dengan data tabel saja
        if ($request->ajax()) {
            return view('seller.orders.partials.orders_table', [
                'orders' => $orders,
            ])->render();
        }

        // Jika request bukan ajax, maka akan merespon dengan halaman lengkap
        return view('seller.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show($order_id) {
        $order = Order::where('id', $order_id)->first();
        return view('seller.orders.show', [
           'order' => $order
        ]);

    }

    public function confirmOrder($order_id): string
    {
        $order = Order::find($order_id);
        $order->status = 'confirmed';
        $order->update();

        return view('seller.orders.partials.detail_order', [
            'order' => $order,
        ])->render();
    }

    public function rejectOrder(Request $request, $order_id): string
    {
        $reject_msg = $request->input('rejectMsg');
        $order = Order::find($order_id);
        $order->status = 'cancelled';
        $order->reject_msg = $reject_msg;
        $order->update();

        return redirect()->route('seller.orders.index')->with('success', $order_id );
    }

    public function updateStatus(Request $request, $order_id)
    {
        $selectedStatus = $request->input('selectedStatus');

        $order = Order::find($order_id);
        $order->status = $selectedStatus;
        $order->update();

        return view('seller.orders.partials.detail_order', [
            'order' => $order,
        ])->render();
    }

    public function updateResi(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        if ($order === null) {
            return response()->json(['error' => "Order not found."], 404);
        }
        $tracking_no = $request->input('trackingNo');
        $orderShipping = $order->orderShipping;
        $orderShipping->tracking_number = $tracking_no;
        $orderShipping->update();

        return response()->json(['success' => "Tersimpan."]);
    }


}
