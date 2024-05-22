<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CategoryService {
    public function getIds($id): ?string {
        $cats = self::getCats();

        $ids = null;
        foreach ($cats as $k => $v) {
            if ($v->parent_id == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }

    public function getProducts($id,$perPage,$query=null) {
        $childIds = $this->getIds($id);
        $childIds = $childIds ? $childIds . $id : $id;

        if(!$query){
            return Product::whereIn('category_id', explode(',', $childIds))->paginate($perPage);
        }

        if($id){
            $query = $query->whereIn('category_id', explode(',', $childIds));
        }

        return $query->paginate($perPage);
    }

    public static function getCats() {
        if (Cache::has("cats")) {
            $cats = Cache::get("cats");
        } else {
            $cats = DB::table("Category")->get()->keyBy('id')->toArray();
            Cache::put("cats", $cats, now()->addHours(24));
        }

        return $cats;
    }
}
