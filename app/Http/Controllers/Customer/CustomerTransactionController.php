<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\UserTransaction;
use Illuminate\Http\Request;

class CustomerTransactionController extends Controller
{
    public function index(Request $request)
    {
        $payment_type = $request->input('status', null);

        $query = UserTransaction::with('order', 'withdrawal')
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
