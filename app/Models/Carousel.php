<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|string|null $user_id
 * @property mixed $name
 * @property mixed $link_path
 * @property mixed|string $image_path
 */
class Carousel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
