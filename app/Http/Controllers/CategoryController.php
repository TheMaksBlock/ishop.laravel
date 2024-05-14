<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Services\BreadCrumbsService;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CategoryService;
use App\Services\CurrencyService;
use App\Services\RecentlyViewedService;
use function PHPUnit\Framework\isEmpty;


class CategoryController extends Controller {
    private $currencyService;
    private $categoriesMenuService;
    private $cartService;
    private $breadCrumbsService;
    private $categoryService;

    private $perPage = 3;

    public function __construct(BreadCrumbsService $breadCrumbsService,
                                CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu,
                                CartService           $cartService,
                                CategoryService $categoryService) {
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
        $this->cartService = $cartService;
        $this->breadCrumbsService = $breadCrumbsService;
        $this->categoryService = $categoryService;
    }

    public function show(Category $category) {
        $products = $this->categoryService->getProducts($category->id,$this->perPage);

        $categoryTitle = $category->title;
        $breadCrumbs = $this->breadCrumbsService->getBreadCrumbs($category->id);
        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cartSum = $this->cartService->getCartSum();
        return view('category.show', compact( "products","breadCrumbs","currencyWidget", "currency",
            "menu", "cartSum", "categoryTitle"));
    }
}
