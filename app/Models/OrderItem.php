<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'subtotal',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

}
