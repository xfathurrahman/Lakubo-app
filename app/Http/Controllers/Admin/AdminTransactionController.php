<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTransaction;
use App\Models\StoreTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTransactionController extends Controller

{
    public function storeTransactions(Request $request)
    {
        $payment_type = $request->input('status', null);

        $query = StoreTransaction::with('order', 'storeWithdrawal')->orderBy('created_at', 'desc');

        if ($payment_type) {
            $query->where('payment_type', $payment_type);
        }

        $transactions = $query->get();

        if ($request->ajax()) {
            return view('admin.transaction.partials.transaction_table', [
                'transactions' => $transactions,
            ])->render();
        }

        return view('admin.transaction.stores.index', [
            'transactions' => $transactions,
        ]);
    }

    public function customerTransactions(Request $request)
    {
        $payment_type = $request->input('status', null);

        $query = UserTransaction::with('order', 'withdrawal')->orderBy('created_at', 'desc');

        if ($payment_type) {
            $query->where('payment_type', $payment_type);
        }
        $transactions = $query->get();

        if ($request->ajax()) {
            return view('admin.transaction.partials.transaction_customer_table', [
                'transactions' => $transactions,
            ])->render();
        }

        return view('admin.transaction.customers.index', [
            'transactions' => $transactions,
        ]);
    }
}
