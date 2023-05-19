<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerWithdrawalController extends Controller
{
    public function index()
    {
        $user_balance = Auth::user()->balance;
        return view('customer.withdraw.index', [
            'balance' => $user_balance
        ]);
    }

    public function store(Request $request)
    {
        $amount = $request->input('amount');

        if ($amount <= Auth::user()->balance)
        {
            if ($amount >= 10000)
            {
                $userWd = new UserWithdrawal;
                $userWd->user_id = Auth::id();
                $userWd->amount = $amount;
                $userWd->bank_name = Auth::user()->bank_name;
                $userWd->bank_account_name = Auth::user()->bank_account_name;
                $userWd->bank_account_number = Auth::user()->bank_account_number;
                $userWd->save();

                $userTrans = new UserTransaction;
                $userTrans -> user_id = Auth::id();
                $userTrans -> withdrawal_id = $userWd->id;
                $userTrans -> amount = $amount;
                $userTrans -> payment_method = 'Bank Transfer';
                $userTrans -> payment_type = 'withdrawal';
                $userTrans -> save();

                $userBalance = User::query()->find(Auth::id());
                $userBalance -> balance -= $amount;
                $userBalance -> update();

                return redirect()->route('customer.transaction.index');
            }

            session()->flash('error', 'Maaf, jumlah penarikan yang diminta harus setidaknya sebesar Rp. 10.000. Mohon pastikan bahwa jumlah penarikan yang Anda masukkan mencukupi syarat ini.');
            return back();

        }

        session()->flash('error', 'Jika jumlah saldo yang Anda miliki kurang dari jumlah yang ingin ditarik, maka penarikan tidak dapat dilakukan. Harap periksa kembali jumlah saldo yang Anda miliki dan jumlah penarikan yang Anda inginkan.');
        return back();

    }
}
