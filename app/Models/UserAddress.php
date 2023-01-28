<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string)
 * @method static find(int|string|null $uid)
 */
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

    public function province()
    {
        return $this->hasOne(Province::class,'id', 'province_id');
    }

    public function regency()
    {
        return $this->hasOne(Regency::class,'id', 'regency_id');
    }

    public function district()
    {
        return $this->hasOne(District::class,'id', 'district_id');
    }

    public function village()
    {
        return $this->hasOne(Village::class,'id', 'village_id');
    }

}
