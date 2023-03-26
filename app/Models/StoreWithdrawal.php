<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static find(int|string|null $id)
 */
class StoreWithdrawal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class,'store_id', 'id');
    }

    public function storeTransaction()
    {
        return $this->hasOne(StoreTransaction::class,'withdrawal_id', 'id');
    }
}
