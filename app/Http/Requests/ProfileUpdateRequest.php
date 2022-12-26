<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'provinsi'=> ['required'],
            'kabupaten'=> ['required'],
            'kecamatan'=> ['required'],
            'desa'=> ['required'],
            'detail_alamat'=> ['required'],
            'nama_lengkap' => ['required','string', 'max:255'],
            'username' => ['required','string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'nomor_handphone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:11','max:13'],
            'email' => ['required','email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => __('Nama pengguna wajib di isi.'),
        ];
    }

}
