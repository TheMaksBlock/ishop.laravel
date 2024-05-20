<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\BreadCrumbsService;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CategoryService;
use App\Services\CurrencyService;
use App\Services\FilterService;
use Illuminate\Http\Request;



class CategoryController extends Controller {
    private $currencyService;
    private $categoriesMenuService;
    private $cartService;
    private $breadCrumbsService;
    private $categoryService;

    private $perPage = 9;

    private $filterService;

    public function __construct(BreadCrumbsService    $breadCrumbsService,
                                CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu,
                                CartService           $cartService,
                                CategoryService       $categoryService,
                                FilterService         $filterService) {
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
        $this->cartService = $cartService;
        $this->breadCrumbsService = $breadCrumbsService;
        $this->categoryService = $categoryService;
        $this->filterService = $filterService;
    }

    public function show(Category $category, Request $request) {
        if($request->ajax()){
            $request->merge(['page' => 1]);
        }
        $filterMenu = $this->filterService->getFilterHTML($request->get('filter'));

        $query = $this->filterService->filterProducts( $request->get('filter'));
        $products = $this->categoryService->getProducts($category->id, $this->perPage,$query);

        $categoryTitle = $category->title;
        $breadCrumbs = $this->breadCrumbsService->getBreadCrumbs($category->id);
        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cartSum = $this->cartService->getCartSum();
        $partial = $request->ajax();

        if($partial){
            return view('products.indexPartial', compact("products","currency", "partial"));
        }

        return view('category.show', compact("products", "breadCrumbs", "currencyWidget", "currency",
            "menu", "cartSum", "categoryTitle", "filterMenu", "partial"));


    }
}
