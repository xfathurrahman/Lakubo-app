<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'image_order',
    ];

    protected $cast = ['image_path' => 'array'];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
