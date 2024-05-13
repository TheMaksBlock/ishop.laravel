<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CategoryService {
    public function getIds($id): ?string {
        $cats = Cache::get('cats');

        $ids = null;
        foreach ($cats as $k => $v) {
            if ($v->parent_id == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }

    public function getProducts($id){
        $childIds = $this->getIds($id);
        $childIds = $childIds?$childIds.$id:$id;

        return Product::whereIn('category_id', explode(',', $childIds))->get();
    }
}
