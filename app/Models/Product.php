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
        return $this->hasMany(RelatedProduct::class, 'product_id', 'id')->get();
    }

    public function getRelatedProducts()
    {
        $relatedProducts = $this->relatedProducts();
        $related = [];
        foreach ($relatedProducts as $prod){
            $related[] = $prod->related;
        }
        return $related;
    }

    public function modifications()
    {
        return $this->hasMany(Modification::class, 'product_id', 'id')->get();
    }
}
