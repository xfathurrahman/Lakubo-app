<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'nama_produk' => 'required|string|max:120',
            'kategori' => 'required',
            'harga' => 'required|max:10',
            'stok' => 'required|max:7',
            'berat' => 'required|max:7',
            'deskripsi' => 'required|string|max:1000',
        ];

        if ($this->getMethod() == 'POST' || !$this->filled('old')) {
            $rules['files'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'files.required' => __('Wajib mengunggah minimal 1 gambar produk.'),
        ];
    }
}
