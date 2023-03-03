<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static id()
 * @method static find($id)
 * @method static orderBy(string $string, string $string1)
 * @method static when(bool $param, \Closure $param1)
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'name',
        'price',
        'description',
        'category_id',
        'quantity',
        'weight',
    ];

    public function stores()
    {
        return $this->belongsTo(Store::class,'store_id', 'id');
    }

    public function productCategories(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class,'category_id', 'id');
    }

    public function productImage()
    {
        return $this->hasOne(ProductImage::class,'product_id','id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
}
