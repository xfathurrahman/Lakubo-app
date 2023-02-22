<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $product_id)
 * @method static find($cart_id)
 */
class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class,'cart_id','id');
    }
    public function stores()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }
}
