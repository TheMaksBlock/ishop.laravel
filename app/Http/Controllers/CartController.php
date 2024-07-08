<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CartController extends Controller {
    private $cartService;
    private $currencyService;
    private $categoriesMenuService;

    public function __construct(CartService           $cartService,
                                CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu,
                                OrderService          $orderService) {
        $this->cartService = $cartService;
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
    }

    public function add(Request $request) {
        $id = $request->get('id');
        $this->cartService->add($id, 1);
        $cart = $this->cartService->getCart();

        if ($request->ajax()) {
            $currency = $this->currencyService->currency;
            return view('cart.index_modal', compact('cart', 'currency'));
        }
        redirect();
    }

    public function delete(Request $request) {
        $id = $request->get('id');

        if ($id) {
            $this->cartService->delete($id);
        }

        $cart = CartService::getCart();

        if ($request->ajax()) {
            return view('cart.index_modal', compact('cart'));
        }

        redirect();
    }

    public function clear() {
        $this->cartService->clear();

        $cart = $this->cartService->getCart();
        return view('cart.index_modal', compact('cart'));
    }

    public function show(Request $request) {
        $currency = $this->currencyService->currency;
        if ($request->ajax()) {
            $cart = $this->cartService->getCart();
            return view('cart.index_modal', compact('cart', 'currency'));
        }
        return redirect()->route("cart.index");
    }

    public function index(Request $request) {
        $currencyWidget = $this->currencyService->getHtml();
        $menu = $this->categoriesMenuService->get();
        $cart = $this->cartService->getCart();
        $currency = $this->currencyService->currency;
        return view('cart.index', compact('cart', "menu", 'currencyWidget', "currency"));
    }
}
