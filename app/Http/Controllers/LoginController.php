<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
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
        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        $cartSum = $this->cartService->getCartSum();
        return view('user.login', compact("currencyWidget", "currency", "menu", "cartSum"));
    }

    public function login(Request $request) {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            // Аутентификация успешна
            return redirect()->route('main.index');
        }

        // Если аутентификация не удалась
        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('main.index');
    }
}
