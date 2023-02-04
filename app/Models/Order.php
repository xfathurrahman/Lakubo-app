<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'status',
        'total_price',
        'shipping',
        'resi',
        'note',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany( OrderItem::class,'order_id','id');
    }

    public function orderAddresses()
    {
        return $this->hasOne(OrderAddress::class,'order_id', 'id');
    }

}
