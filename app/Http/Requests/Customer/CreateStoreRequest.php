<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nama'=> 'required|string|max:50',
            'kategori'=> 'required|string',
            'deskripsi'=> 'required|string',
            // store address
            'kecamatan' => 'required',
            'desa'=> 'required',
            'detail_alamat' => 'required|string'
        ];
    }
}
