<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class RecentlyViewedService {

    public function setRecentlyViewed($id)
    {
        $recentlyViewed = $this->getAllRecentlyViewed();
        if(!$recentlyViewed){
            $this->setCookie($id);
        }
        else{
            $recentlyViewed = explode(',', $recentlyViewed);
            if(!in_array($id, $recentlyViewed)){
                $recentlyViewed[] = $id;
                $this->setCookie(implode(',', $recentlyViewed));
            }
        }
    }

    public function getRecentlyViewed()
    {
        $recentlyViewed = Cookie::get('recentlyViewed');
        if(!empty($recentlyViewed)){
            $recentlyViewed = explode(',', $recentlyViewed);
            return array_slice($recentlyViewed, -3);
        } else {
            return false;
        }
    }

    public function getRecentlyViewedProducts(){
        $ids = $this->getRecentlyViewed();
        if($ids){
            return Product::whereIn("id",$ids)->get();
        }
    }

    public function getAllRecentlyViewed()
    {
        return Cookie::get("recentlyViewed");
    }

    protected function setCookie($value)
    {
        Cookie::queue('recentlyViewed', $value, 60*24);
    }
}
