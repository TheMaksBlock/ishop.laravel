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

}
