<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class BreadCrumbsService {

    public function getBreadCrumbs($categoryId, $name = '') {

        if(is_null(Cache::get("cats"))){
            $cats = Category::all()->mapWithKeys(function ($category) {
                return [$category['id'] => [
                    'alias' => $category['alias'],
                    'title' => $category['title'],
                    'parent_id' => $category['parent_id'],
                ]];
            })->toArray();

            Cache::put("cats", $cats, now()->addHours(24));
        }
        else{
            $cats = Cache::get("cats");
        }


        $breadCrumbsArray = self::getParts($cats, $categoryId);
        $breadCrumbs = "<li><a href='" . route("main.index") . "'>Главная</a> </li>";
        if ($breadCrumbsArray) {
            foreach ($breadCrumbsArray as $alias => $title) {
                $breadCrumbs .= "<li><a href='" . url('/category/' . $alias) . "'>$title</a> </li>";
            }
        }
        if ($name) {
            $breadCrumbs .= "<li>{$name}</li>";
        }
        return $breadCrumbs;
    }

    public function getParts($cats, $categoryId): false|array {
        if (!$categoryId)
            return false;
        $breadCrumbs = [];
        while (isset($cats[$categoryId])) {
            $breadCrumbs[$cats[$categoryId]['alias']] = $cats[$categoryId]['title'];
            $categoryId = $cats[$categoryId]['parent_id'];
        }
        return array_reverse($breadCrumbs);
    }

    public static function getCats() {
        // Получаем категории из кэша, если они там есть, иначе выполняем запрос к базе данных
        Cache::remember('categories', 60*24, function () {
            return Category::all();
        });
    }
}
