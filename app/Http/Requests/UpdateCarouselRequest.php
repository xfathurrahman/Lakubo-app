<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 */
class UpdateCarouselRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'       => 'required',
        ];
    }
}
