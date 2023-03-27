<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StoreWithdrawal;
use App\Models\StoreTransaction;
use Illuminate\Support\Facades\Auth;

class StoreWithdrawalController extends Controller
{
    public function index()
    {
        $store_balance = Auth::user()->stores->balance;
        return view('seller.withdraw.index', [
            'balance' => $store_balance
        ]);
    }

    public function store(Request $request)
    {
        $amount = $request->input('amount');

        if ($amount <= Auth::user()->stores->balance)
        {
            if ($amount >= 10000)
            {
                $storeWd = new StoreWithdrawal;
                $storeWd->store_id = Auth::user()->stores->id;
                $storeWd->amount = $amount;
                $storeWd->bank_name = Auth::user()->stores->bank_name;
                $storeWd->bank_account_name = Auth::user()->stores->bank_account_name;
                $storeWd->bank_account_number = Auth::user()->stores->bank_account_number;
                $storeWd->save();

                $storeTrans = new StoreTransaction;
                $storeTrans -> store_id = Auth::user()->stores->id;
                $storeTrans -> withdrawal_id = $storeWd->id;
                $storeTrans -> amount = $amount;
                $storeTrans -> payment_method = 'Bank Transfer';
                $storeTrans -> payment_type = 'withdrawal';
                $storeTrans -> save();

                $storeBalance = User::find(Auth::user()->stores->id);
                $storeBalance -> balance -= $amount;
                $storeBalance -> update();

                return redirect()->route('seller.transaction.index');
            }

            session()->flash('error', 'Maaf, jumlah penarikan yang diminta harus setidaknya sebesar Rp. 10.000. Mohon pastikan bahwa jumlah penarikan yang Anda masukkan mencukupi syarat ini.');
            return back();

        }

        session()->flash('error', 'Jika jumlah saldo yang Anda miliki kurang dari jumlah yang ingin ditarik, maka penarikan tidak dapat dilakukan. Harap periksa kembali jumlah saldo yang Anda miliki dan jumlah penarikan yang Anda inginkan.');
        return back();

    }
}
