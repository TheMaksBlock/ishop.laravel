<?php

namespace App\Services\admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use function PHPUnit\Framework\isEmpty;

class CacheService {

    private static $cats = ["Категории" => ["ishop_menu", "admin_cat", "admin_select"]];

    public static function forgetGroup(string $name): void {
        if (isset(self::$cats[$name])) {
            foreach (self::$cats[$name] as $key) {
                Cache::forget($key);
            }
        }
    }


}
