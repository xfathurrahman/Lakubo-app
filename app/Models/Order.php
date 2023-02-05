<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderItems(): HasMany
    {
        return $this->hasMany( OrderItem::class,'order_id','id');
    }

    public function orderAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class,'order_id', 'id');
    }

}
