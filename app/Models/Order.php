<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * @method static where(string $string, $order_id)
 * @method static find(mixed $invoce)
 */
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

    public function orderShipping(): HasOne
    {
        return $this->hasOne(OrderShipping::class,'order_id', 'id');
    }

}
