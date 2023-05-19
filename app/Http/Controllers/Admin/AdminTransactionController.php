<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTransaction;
use App\Models\StoreTransaction;
use App\Models\StoreWithdrawal;
use App\Models\UserWithdrawal;
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
            return view('admin.transaction.partials.transaction_store_table', [
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

    public function storeTransactionUpdate(Request $request)
    {
        $transactionId = $request->input('transactionId');
        $status = $request->input('status');
        // Lakukan validasi data jika diperlukan
        // Perbarui status transaksi di database
        $transaction = StoreWithdrawal::with('store')->find($transactionId);
        $transaction->status = $status;
        $transaction->save();
        // Jika status ditolak, kembalikan saldo
        if ($status === 'rejected') {
            $store = $transaction->store;
            $store->balance += $transaction->amount;
            $store->save();
        }
        // Berikan respons sukses ke klien
        return response()->json(['message' => 'Status transaksi berhasil diperbarui'], 200);
    }

    public function customerTransactionUpdate (Request $request)
    {
        $transactionId = $request->input('transactionId');
        $status = $request->input('status');
        // Lakukan validasi data jika diperlukan
        // Perbarui status transaksi di database
        $transaction = UserWithdrawal::with('user')->find($transactionId);
        $transaction->status = $status;
        $transaction->save();
        // Jika status ditolak, kembalikan saldo
        if ($status === 'rejected') {
            $user = $transaction->user;
            $user->balance += $transaction->amount;
            $user->save();
        }
        // Berikan respons sukses ke klien
        return response()->json(['message' => 'Status transaksi berhasil diperbarui'], 200);
    }
}
