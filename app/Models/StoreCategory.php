<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 * @method static orderBy(string $string, string $string1)
 */
class StoreCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image'
    ];

    protected $hidden = [];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

}
