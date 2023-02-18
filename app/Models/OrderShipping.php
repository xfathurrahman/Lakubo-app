<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($order_id)
 */
class OrderShipping extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

}
