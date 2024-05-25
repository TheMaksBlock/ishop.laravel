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
    private $orderService;

    public function __construct(CartService           $cartService,
                                CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu,
                                OrderService          $orderService) {
        $this->cartService = $cartService;
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
        $this->orderService = $orderService;
    }

    public function add(Request $request) {
        $id = $request->get('id');
        $this->cartService->add($id, 1);
        $cart = CartService::getCart();

        if ($request->ajax()) {
            return view('cart.index_modal', compact('cart'));
        }
        redirect();
    }

    public function showAction() {
        $this->loadView('cart_model');
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
        CartService::clear();

        $cart = CartService::getCart();
        return view('cart.index_modal', compact('cart'));
    }

    public function show(Request $request) {
        if ($request->ajax()) {
            $cart = CartService::getCart();
            return view('cart.index_modal', compact('cart'));
        } else $this->index($request);
    }

    public function index(Request $request) {
        $currencyWidget = $this->currencyService->getHtml();
        $menu = $this->categoriesMenuService->get();
        $cart = CartService::getCart();
        $cartSum = $this->cartService->getCartSum();
        $currency = $this->currencyService->currency;
        return view('cart.index', compact('cart', "menu", 'currencyWidget', "cartSum", "currency"));
    }

    public function checkout(Request $request) {
        $this->orderService->saveOrder($request->get("note"), $this->currencyService->currency);

        return redirect()->route('cart.index')->with('success', 'Товары заказаны');
    }
}
