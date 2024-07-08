<?php

namespace App\Http\Controllers;

use App\Events\UserLogined;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
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
        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cart = $this->cartService->getCart();
        return view('user.login', compact("currencyWidget", "currency", "menu","cart"));
    }

    public function login(Request $request) {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            event(new UserLogined(Auth::user()->id));
            return redirect()->route('main.index');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('main.index');
    }
}
