<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string)
 * @method static find(mixed $id)
 */
class StoreAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'detail_address',
        'embedded_map',
    ];

    public function stores()
    {
        return $this->belongsTo(Store::class,'store_id', 'id');
    }
}
