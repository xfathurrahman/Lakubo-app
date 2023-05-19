<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;

class AdminStoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('users','products','storeCategories')
            ->Paginate(10)
            ->onEachSide(2);

        return view('admin.store.index', compact('stores'));
    }

    public function destroy($store) {

        $store = Store::query()->find($store);

        if ($store) {
            // Memeriksa apakah ada order terkait dengan lapak ini
            $hasOrders = Order::query()->where('store_id', $store->id)->exists();
            if ($hasOrders) {
                return redirect('admin/stores')->with('error', 'Pelapak sedang dalam transaksi.');
            }
            $store->products->delete();
            return redirect('admin/stores')->with('success', 'Pelapak berhasil dihapus.');
        }

        return redirect('admin/stores')->with('success', 'Pelapak tidak ditemukan.');
    }

}
