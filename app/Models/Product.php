<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    public function related(){
        return $this->belongsTo(RelatedProduct::class);
    }

    public function relatedProducts()
    {
        return $this->hasMany(RelatedProduct::class, 'product_id', 'id');
    }
}
