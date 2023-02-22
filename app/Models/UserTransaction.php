<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, int|string|null $id)
 */
class UserTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id', 'id');
    }

    public function withdrawal()
    {
        return $this->belongsTo(UserWithdrawal::class,'withdrawal_id', 'id');
    }
}
