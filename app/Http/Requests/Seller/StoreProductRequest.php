<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'=>'required|string|max:120',
            'kategori'=>'required',
            'price'=>'required|max:10',
            'quantity'=>'required|max:7',
            'weight'=>'required|max:7',
            'description'=>'required|string|max:1000',
            'files' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'files.required' => __('Wajib menggunggah minimal 1 gambar produk.'),
        ];
    }

}
