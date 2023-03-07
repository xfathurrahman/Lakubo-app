<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $product_id)
 * @property mixed $cart_id
 * @property int|mixed|string|null $user_id
 * @property mixed $product_id
 * @property mixed $product_qty
 */
class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'user_id',
        'product_id',
        'product_qty',
        'note',
    ];
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function carts()
    {
        return $this->belongsTo(Cart::class,'cart_id','id');
    }

}
