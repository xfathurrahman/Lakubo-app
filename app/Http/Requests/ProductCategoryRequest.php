<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Nama kategori wajib diisi.'),
            'image.required' => __('Wajib menggunggah gambar kategori produk.'),
        ];
    }

}
