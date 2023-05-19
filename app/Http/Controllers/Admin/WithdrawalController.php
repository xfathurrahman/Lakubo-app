<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreWithdrawal;
use App\Models\UserWithdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function customerIndex(Request $request)
    {
        $status = $request->input('status', null);

        $query = UserWithdrawal::orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $custWds = $query->get();

        if ($request->ajax()) {
            return view('admin.withdrawal.partials.wd_customer_table', [
                'custWds' => $custWds,
            ])->render();
        }

        return view('admin.withdrawal.customers.index', [
            'custWds' => $custWds,
        ]);
    }

    public function storeIndex(Request $request)
    {
        $status = $request->input('status', null);

        $query = StoreWithdrawal::orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $storeWds = $query->get();

        if ($request->ajax()) {
            return view('admin.withdrawal.partials.wd_store_table', [
                'storeWds' => $storeWds,
            ])->render();
        }

        return view('admin.withdrawal.stores.index', [
            'storeWds' => $storeWds,
        ]);
    }
}
