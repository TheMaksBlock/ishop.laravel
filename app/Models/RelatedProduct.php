<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use HasFactory;
    protected $table = 'related_product';
    protected $guarded = [];
    public $timestamps = false;
    public function related(){
        return $this->hasOne(Product::class, "id","related_id");
    }
}
