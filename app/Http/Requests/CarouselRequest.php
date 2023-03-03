<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $image
 * @property mixed $name
 * @property mixed $link_path
 */
class CarouselRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => 'required',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama carousel wajib diisi',
            'image.required' => 'Carousel wajib diunggah',
            'image.image' => 'Carousel harus dalam format gambar (jpeg, png, bmp, gif, atau svg)',
        ];
    }
}
