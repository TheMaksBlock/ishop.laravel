<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;
    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }
    public function add(Request $request){
        $id = $request->get('id');
        $this->cartService->add($id,1);
        $cart = $this->cartService->getCart();

        if($request->ajax()){
            return view('cart.index_modal',compact('cart'));
        }
        redirect();
    }

    public function showAction(){
        $this->loadView('cart_model');
        redirect();
    }

    public function deleteAction()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] :null;

        if(isset($_SESSION['cart'][$id])){
            $cart = new Cart();
            $cart->deleteItem($id);
        }

        if($this->isAjax()){
            $this->loadView('cart_model');
        }
        redirect();
    }

    /*public function clearAction()
    {
        Cart::clear();

        $this->loadView('cart_model');
    }*/

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
