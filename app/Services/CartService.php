<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;

class CartService {
    public function add($id, $qty) {
        $user = Auth::user();

        if ($user) {
            $this->addBd($id, $qty, $user);
        } else {
            $this->addSession($id, $qty);
        }

    }

    public function addBd($id, $qty, $user) {
        if ($id>0 && $qty > 0) {
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $qty;
            } else {
                $cartItem = new CartItem([
                    'user_id' => $user->id,
                    'product_id' => $id,
                    'quantity' => $qty,
                ]);
            }

            $cartItem->save();
        }
    }

    public function addSession($id, $qty) {
        if ($id && $qty) {
            $cart = Session::get("cart");

            if (!$cart) {
                $cart = [];
            }

            $item = $cart[$id] ?? null;

            if ($item) {
                $cart[$id]['qty'] += $qty;
            } else {
                $cart[$id] = [
                    'qty' => $qty
                ];
            }

            Session::put("cart", $cart);
        }
    }

    public function delete($id) {
        if(Auth::user()){
            $this->deleteBd($id);
        }else{
            $this->deleteSession($id);
        }

    }

    private function deleteBd($id){
        $cartItem = CartItem::where('user_id', Auth::user()->id)
            ->where('product_id', $id);

        if ($cartItem) {
            $cartItem->delete();
        }
    }

    private function deleteSession($id,) {
        $cart = Session::get('cart');
        if ($cart && isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
    }


    public function getCart() {
        $user = Auth::user();
        $currency = (new CurrencyService())->currency;
        if ($user) {
            $items = $user->cartItems()->withPivot("quantity")->get();
            foreach ($items as $item) {
                $item->quantity = $item->pivot->quantity;
                $item->price*=$currency["value"];
            }
        } else {
            $cart = Session::get('cart');
            if (!empty($cart)) {
                $items = Product::whereIn("id", array_keys($cart))->get();
                foreach ($items as $item) {
                    $item->quantity = $cart[$item->id]["qty"];
                    $item->price*=$currency["value"];
                }
            } else {
                $items = new Collection();
            }
        }

        $cart = [
            "qty" => $items->sum('quantity'),
            "sum" => $this->getCartSum($items),
            "items" => $items
        ];

        return $cart;
    }

    public function clear() {
        $user = Auth::user();

        if ($user) {
            $items = $user->cart;
            foreach ($items as $item) {
                $item->delete();
            }
        } else {
            Session::forget("cart");
        }
    }

    public function getCartSum($items) {
        $sum = 0;

        foreach ($items as $item) {
            $sum += $item->price * $item->quantity;
        }
        return $sum;
    }

    public function moveCart() {

        $cart = Session::get('cart');
        if ($cart) {
            foreach ($cart as $key => $value) {
               $this->add($key, $value["qty"]);
            }
        }

        Session::forget('cart');
    }

}
