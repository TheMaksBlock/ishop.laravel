<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Services\BreadCrumbsService;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use App\Services\RecentlyViewedService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private $currencyService;
    private $categoriesMenuService;
    private $cartService;

    public function __construct(CurrencyService $currencyService,
                                CategoriesMenuService $categoryMenu,
                                CartService $cartService) {
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
        $this->cartService = $cartService;
    }

    public function index(){
        $brands = Brand::take(3)->get();
        $hits =Product::where('hit','1')
            ->where('status', "1")
            ->take(8)
            ->get();

        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cartSum = $this->cartService->getCartSum();
        return view('main.index', compact("brands", "hits", "currencyWidget", "currency", "menu", "cartSum"));
    }
}
