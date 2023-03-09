<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'files' => 'required',
            'nama_produk'=>'required|string|max:120',
            'kategori'=>'required',
            'harga'=>'required|max:10',
            'stok'=>'required|max:7',
            'berat'=>'required|max:7',
            'deskripsi'=>'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'files.required' => __('Wajib menggunggah minimal 1 gambar produk.'),
        ];
    }

}
