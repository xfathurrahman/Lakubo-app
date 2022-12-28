<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function stores()
    {
        return $this->belongsTo(Store::class,'store_id', 'id');
    }
}
