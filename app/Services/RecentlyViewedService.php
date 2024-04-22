<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class RecentlyViewedService {

    public function setRecentlyViewed($id)
    {
        $recentlyViewed = Cookie::get("recentlyViewed");;
        if(!$recentlyViewed){
            Cookie::queue('recentlyViewed', $id, 60*24);
        }
        else{
            $recentlyViewed = explode(',', $recentlyViewed);
            if(!in_array($id, $recentlyViewed)){
                $recentlyViewed[] = $id;
                Cookie::queue('recentlyViewed', implode(',', $recentlyViewed), 60*24);
            }
        }
    }

    public function getRecentlyViewed($id)
    {
        $recentlyViewed = Cookie::get('recentlyViewed');
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
