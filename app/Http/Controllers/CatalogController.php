<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\BreadCrumbsService;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CatalogService;
use App\Services\CurrencyService;
use App\Services\FilterService;
use Illuminate\Http\Request;


class CatalogController extends Controller {
    private $currencyService;
    private $categoriesMenuService;
    private $cartService;
    private $breadCrumbsService;
    private $categoryService;

    private $perPage = 9;

    private $filterService;
    private $searchLimit = 10;

    public function __construct(BreadCrumbsService    $breadCrumbsService,
                                CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu,
                                CartService           $cartService,
                                CatalogService        $categoryService,
                                FilterService         $filterService) {
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
        $this->cartService = $cartService;
        $this->breadCrumbsService = $breadCrumbsService;
        $this->categoryService = $categoryService;
        $this->filterService = $filterService;
    }


    public function typeahead(Request $request) {

        if ($request->ajax()) {
            $query = trim($request->get('query'));

            if (!empty($query)) {
                $products = Product::select('id', 'title')
                    ->where('title', 'LIKE', "%$query%")
                    ->limit($this->searchLimit)->get();

                return response()->json($products);
            }
        }

        return response()->json([]);
    }

    public function show(Category $category, Request $request) {

        if ($request->ajax()) {
            $request->merge(['page' => 1]);
        }

        if ($category->exists) {
            $breadCrumbs = $this->breadCrumbsService->getBreadCrumbs($category->id);
            $id = $category->id;
        } else {
            $breadCrumbs = null;
            $id = null;
        }

        $filterMenu = $this->filterService->getFilterHTML($request->get('filter'));

        $filterQuery = $request->get('filter');
        $searchQuery = $request->get('s');

        $query = $this->filterService->attributesFilter($filterQuery);
        $query = $this->filterService->searchFilter($searchQuery, $query);
        $products = $this->categoryService->getProducts($id, $this->perPage, $query);

        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cartSum = $this->cartService->getCartSum();
        $partial = $request->ajax();

        if ($partial) {
            return view('catalog.partial', compact("products", "currency", "partial"));
        }

        return view('catalog.show', compact("products", "breadCrumbs", "currencyWidget", "currency",
            "menu", "cartSum", "filterMenu", "partial", "searchQuery"));
    }
}
