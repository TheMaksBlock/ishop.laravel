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
        if ($id && $qty > 0) {
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $qty;
            } else {
                $cartItem = new CartItem([
                    'user_id' => $user->id,
                    'product_id' => $id,
                    'quantity' => $id,
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
        $cart = self::getCart();

        if (isset($cart[$id])) {
            $qty = $cart[$id]['qty'];
            $sum = $cart[$id]['price'] * $qty;

            $cart['qty'] -= $qty;
            $cart['sum'] -= $sum;

            unset($cart[$id]);
            Cache::put('cart', $cart, 60 * 24);
        }
    }

    public function getCart() {
        $user = Auth::user();

        if ($user) {
            $items = $user->cartItems()->withPivot("quantity")->get();
            foreach ($items as $item) {
                $item->quantity = $item->pivot->quantity;
            }
        } else {
            $cart = Session::get('cart');
            if (!empty($cart)) {
                $items = Product::whereIn("id", array_keys($cart))->get();
                foreach ($items as $item) {
                    $item->quantity = $cart[$item->id]["qty"];
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
            $cart = $this->getCart();
            unset($cart);
        }
    }

    public function getCartSum($items) {
        $sum = 0;

        foreach ($items as $item) {
            $sum += $item->price * $item->quantity;
        }
        return $sum;
    }

    public static function recalc() {
        $cart = self::getCart();
        if (!$cart) {
            return false;
        }

        $currency = app(CurrencyService::class)->currency;

        foreach ($cart as $k => $v) {
            if ($k !== 'sum' && $k !== 'qty' && $k !== 'currency') {
                $cart[$k]['price'] = $v['price'] / $cart['currency']['value'] * $currency['value'];
            }
        }

        $cart['sum'] = $cart['sum'] / $cart['currency']['value'] * $currency['value'];

        $cart['currency'] = $currency;
        Cache::put('cart', $cart, 60 * 24);
        return true;
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
