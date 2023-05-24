<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreTransaction;
use App\Models\User;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::query()->where('status', 'completed')->get()->count();
        $totalWaitingConfirm = $this->countTotalWaintingConfirm();
        $totalStores = Store::query()->get()->count();
        $totalProducts = Product::query()->get()->count();
        $totalUser = User::query()->get()->count();

        $userTransactions = UserTransaction::all();
        $storeTransactions = StoreTransaction::all();

        $bestSellingProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.quantity) as total_sold'))
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'completed')
        ->groupBy('products.id')
        ->orderByDesc('total_quantity')
        ->take(10) // Ambil 10 produk terlaris
        ->get();

        $topStores = Store::withCount(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])->get();

        return view('admin.index')->with([
            'totalSales' => $totalSales,
            'totalStores' => $totalStores,
            'totalProducts' => $totalProducts,
            'totalUser' => $totalUser,
            'totalWaitingConfirm' => $totalWaitingConfirm,
            'userTransactions' => $userTransactions,
            'storeTransactions' => $storeTransactions,
            'bestSellingProducts' => $bestSellingProducts,
            'topStores' => $topStores,
        ]);
    }

    public function countTotalWaintingConfirm()
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

        $totalOrdersToShow = count($ordersToShow);

        return $totalOrdersToShow;
    }

}
