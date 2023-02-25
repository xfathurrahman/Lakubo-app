<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'image.required' => 'Gambar produk wajib diunggah',
            'image.image' => 'Gambar produk harus dalam format gambar (jpeg, png, bmp, gif, atau svg)',
        ];
    }
}
