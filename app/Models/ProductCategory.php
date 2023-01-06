<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static id()
 * @method static find($id)
 * @method static orderBy(string $string, string $string1)
 */
class ProductCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id','id');
    }
}
