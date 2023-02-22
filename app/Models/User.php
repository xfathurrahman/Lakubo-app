<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static find(int|string|null $id)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function stores()
    {
        return $this->hasOne(Store::class,'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class,'user_id', 'id');
    }

    public function hasItem()
    {
        return $this->hasMany(cartItem::class,'user_id', 'id');
    }

    public function carts()
    {
        return $this->hasManyThrough(Product::class,Cart::class,'product_id','user_id', 'id');
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class,OrderItem::class,'order_id','user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(UserTransaction::class,'user_id', 'id');
    }

}
