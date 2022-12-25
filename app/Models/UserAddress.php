<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'detail_address',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
