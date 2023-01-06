<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nama_lapak' => ['required','string', 'max:255'],
            'kategori_lapak'=> ['required'],
            'deskripsi_lapak'=> ['required','string', 'max:255'],
            'kecamatan'=> ['required'],
            'desa'=> ['required'],
            'detail_alamat'=> ['required'],
        ];
    }
}
