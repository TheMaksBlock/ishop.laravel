<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class RecentlyViewedService {

    public function setRecentlyViewed($id)
    {
        $recentlyViewed = Cache::get('recentlyViewed');
        if(!$recentlyViewed){
            Cache::put('recentlyViewed', $id, 60 * 24);
        }
        else{
            $recentlyViewed = explode(',', $recentlyViewed);
            if(!in_array($id, $recentlyViewed)){
                $recentlyViewed[] = $id;
                Cache::put('recentlyViewed', implode(',', $recentlyViewed), 60 * 24);
            }
        }
    }

    public function getRecentlyViewed($id)
    {
        $recentlyViewed = Cache::get('recentlyViewed');
        if(!empty($recentlyViewed)){
            $recentlyViewed = explode(',', $recentlyViewed);

            $key = array_search($id, $recentlyViewed);
            if ($key !== false) {
                unset($recentlyViewed[$key]);
            }

            return array_slice($recentlyViewed, -3);
        } else {
            return false;
        }
    }

    public function getRecentlyViewedProducts($id){
        $ids = $this->getRecentlyViewed($id);
        if($ids){
            return Product::whereIn("id",$ids)->get();
        }
    }
}
