<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class BreadCrumbsService {

    public function getBreadCrumbs($categoryId, $name = '') {

        $cats = CatalogService::getCats();

        $breadCrumbsArray = self::getParts($cats, $categoryId);
        $breadCrumbs = "<li><a href='" . route("main.index") . "'>Главная</a> </li>";
        if ($breadCrumbsArray) {
            foreach ($breadCrumbsArray as $alias => $title) {
                $breadCrumbs .= "<li><a href='" . route("catalog.show", [$alias]) . "'>$title</a> </li>";
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
            $breadCrumbs[$cats[$categoryId]->alias] = $cats[$categoryId]->title;
            $categoryId = $cats[$categoryId]->parent_id;
        }
        return array_reverse($breadCrumbs);
    }

    public static function getCats() {
        Cache::remember('categories', 60 * 24, function () {
            return Category::all();
        });
    }
}
