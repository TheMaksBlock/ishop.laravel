<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;

class MainController extends Controller {
    private $currencyService;
    private $categoriesMenuService;
    private $cartService;

    public function __construct(CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu,
                                CartService           $cartService) {
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
        $this->cartService = $cartService;
    }

    public function index() {
        $hits = Product::where('hit', '1')
            ->where('status', "1")
            ->take(8)
            ->get();

        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cart = $this->cartService->getCart();
        return view('main.index', compact("hits", "currencyWidget", "currency", "menu", "cart"));
    }
}
