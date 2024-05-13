<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CartController extends Controller {
    private $cartService;
    private $currencyService;
    private $categoriesMenuService;

    public function __construct(CartService           $cartService,
                                CurrencyService       $currencyService,
                                CategoriesMenuService $categoryMenu) {
        $this->cartService = $cartService;
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
    }

    public function add(Request $request) {
        $id = $request->get('id');
        $this->cartService->add($id, 1);
        $cart = $this->cartService->getCart();

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

        $cart = $this->cartService->getCart();

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
        if ($request->ajax()) {
            $cart = $this->cartService->getCart();
            return view('cart.index_modal', compact('cart'));
        } else $this->index($request);
    }

    public function index(Request $request) {
        $currencyWidget = $this->currencyService->getHtml();
        $menu = $this->categoriesMenuService->get();
        $cart = $this->cartService->getCart();
        $cartSum = $this->cartService->getCartSum();
        $currency = $this->currencyService->currency;
        return view('cart.index', compact('cart', "menu", 'currencyWidget', "cartSum", "currency"));
    }

    /*public function viewAction()
    {
        $this->setMeta("Оформление заказа");
    }*/

    /*public function checkoutAction()
    {
        if(!empty($_POST)){
            if(!User::checkAuth()){

                $user = new User();
                $data = $_POST;
                $user->load($data);
                if (!$user->validate() || !$user->checkUnique([
                        "login" => $user->attributes['login'],
                        "email" => $user->attributes['email']
                    ], "user")) {
                    $_SESSION['form_data'] = $data;
                    $user->getErrors();
                    redirect();
                } else {
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);

                    if (!$user_id = $user->save('user')) {
                        $_SESSION['error'] = "Ошибка регистрации";
                        redirect();
                    }

                    $user = new User();
                    $user->login();
                }
            }
        }

        $data['user_id'] = $user_id ?? $_SESSION['user']['id'];
        $data['note'] = !empty($_POST['note']) ? h($_POST['note']) : '';
        $user_email = $_SESSION['user']['email'] ?? $_POST['email'];
        $order_id = Order::saveOrder($data);
        Order::mailOrder($order_id,$user_email);
        Cart::clear();
        redirect();
    }*/
}
