<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'bank_acc_name'=> ['required'],
            'bank_acc_number'=> ['required'],
            'bank_name'=> ['required']
        ];
    }

    public function messages()
    {
        return [
            'bank_acc_name.required' => __('Nama akun rekening bank wajib di isi.'),
            'bank_acc_number.required' => __('Nomor rekening bank wajib di isi.'),
            'bank_name.required' => __('Nama Bank wajib di isi.'),
        ];
    }

}
