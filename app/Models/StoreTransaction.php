<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, int|string|null $id)
 */
class StoreTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class,'store_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id', 'id');
    }

    public function storeWithdrawal()
    {
        return $this->belongsTo(StoreWithdrawal::class,'withdrawal_id', 'id');
    }
}
