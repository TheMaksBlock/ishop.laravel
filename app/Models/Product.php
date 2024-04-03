<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = ['title', 'alias', 'content', 'price', 'old_price', 'status', 'keywords', 'description', 'img', 'hit'];
}
