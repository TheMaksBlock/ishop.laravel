<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $hidden = [
        'password'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->belongsToMany(Product::class, "cart_items", "user_id",
            "product_id");
    }

    public function cart(){
        return $this->hasMany(CartItem::class, "user_id", "id");
    }

}
