<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public $timestamps = false;

    public function related()
    {
        return $this->belongsToMany(__CLASS__, 'related_product', 'product_id', 'related_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gallery(){
        return $this->hasMany(Gallery::class);
    }
}
