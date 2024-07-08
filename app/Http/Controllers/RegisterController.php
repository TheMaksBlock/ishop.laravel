<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
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
        return view('user.register', compact("currencyWidget", "currency", "menu", "cart"));
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // Выполните дополнительную логику, например, авторизацию пользователя или перенаправление
        auth()->login($user);

        return redirect()->route('main.index');
    }
}
