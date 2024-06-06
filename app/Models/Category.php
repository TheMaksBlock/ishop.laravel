<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    public function childs(){
        return $this->hasMany(Category::class, 'parent_id', 'id')->get();
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id')->get();
    }
}
