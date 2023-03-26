<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreTransaction;

class StoreTransactionController extends Controller
{
    public function index(Request $request)
    {
        $payment_type = $request->input('status', null);

        $query = StoreTransaction::with('order', 'withdrawal')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        if ($payment_type) {
            $query->where('payment_type', $payment_type);
        }
        $transactions = $query->get();

        if ($request->ajax()) {
            return view('customer.transaction.partials.transaction_table', [
                'transactions' => $transactions,
            ])->render();
        }

        return view('customer.transaction.index', [
            'transactions' => $transactions,
        ]);
    }
}
