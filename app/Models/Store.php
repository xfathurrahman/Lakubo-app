<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @method static where(string $string, string $string1)
 */
class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'description'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function StoreCategories()
    {
        return $this->belongsTo(StoreCategory::class,'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'store_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'store_id', 'id');
    }

    public function storeAddresses()
    {
        return $this->hasOne(StoreAddress::class,'store_id', 'id');
    }
}
