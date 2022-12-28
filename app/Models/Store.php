<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'description'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function StoreAddresses()
    {
        return $this->hasOne(StoreAddress::class,'store_id', 'id');
    }
}
