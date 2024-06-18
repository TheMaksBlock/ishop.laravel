<?php

namespace App\Services\admin;

use Illuminate\Support\Facades\Cache;
use function Laravel\Prompts\select;

class CacheService {

    private static $cats = [
        "Категории" =>
            ["ishop_menu" => "Меню на главной странице",
                "admin_cat" => "Меню категорий администратора",
                "admin_select" => "Меню выбора родительской категории"]];

    private static $link = "admin.cache.forget";
    private static $groupLink = "admin.cache.forgetGroup";
    private static $allLink = "admin.cache.forgetAll";

    public static function forgetGroup(string $name): void {
        if (isset(self::$cats[$name])) {
            foreach (self::$cats[$name] as $key => $value) {
                self::forget($key);
            }
        }
    }

    public static function forgetAll() {
        foreach (self::$cats as $key=>$value) {
            self::forgetGroup($key);
        }
    }

    public static function forget(string $key): void {
        if (Cache::has($key)) {
            Cache::forget($key);
        }
    }

    public static function getHtml() {
        $str = '<div class="list-group list-group-root well">';

        $str .= '<p class="item-p">
            <a class="list-group-item">Очистить всё</a>
            <span>
                <a href="'.route(self::$allLink).'" class="delete">
                    <i class="fa fa-fw fa-close text-danger"></i>
                </a>
            </span>
        </p>';

        foreach (self::$cats as $key => $value) {
            $str .= self::getTemplate($key, $key, self::$groupLink);
            $str .= '<div class="list-group">';
            foreach ($value as $k => $v) {
                $str .= self::getTemplate($k, $v, self::$link);
            }
            $str .= "</div>";
        }

        $str .= "</div>";
        return $str;
    }

    private static function getTemplate($key, $value, $path) {
        return view("admin.templates.cache_tpl", compact("key", "value", "path"))->render();
    }

}
