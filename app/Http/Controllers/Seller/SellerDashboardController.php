<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index()
    {

        if (is_null(auth()->user()->stores)){
            return back()->with('error','Anda belum memiliki Lapak UMKM');
        }

        $countSuccessOrders = auth()->user()->stores->with(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])->get()->pluck('orders')->flatten()->count();

        $countNewOrders = auth()->user()->stores->with(['orders' => function ($query) {
            $query->where('status', 'awaiting_confirm');
        }])->get()->pluck('orders')->flatten()->count();

        $topProductSales = Product::query()->where('store_id', auth()->user()->stores->id)->take(4)->get();
        $transactionSuccess = Order::query()->where('store_id', auth()->user()->stores->id)->where('status', 'completed')->take(12)->get();

        # count grant_total from table orders where status = completed
        $totalSales = auth()->user()->stores->with(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])->get()->pluck('orders')->flatten()->sum('grand_total');

        return view('seller.index')->with([
            'countSuccessOrders' => $countSuccessOrders,
            'countNewOrders' => $countNewOrders,
            'topProductSales' => $topProductSales,
            'transactionSuccess' => $transactionSuccess,
            'totalSales' => $totalSales
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
