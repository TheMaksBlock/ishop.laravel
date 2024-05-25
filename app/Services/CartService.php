<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CartService {
    public function add($id, $qty) {
        if ($id) {
            $product = Product::firstWhere('id', $id);

            if (!$product) {
                return false;
            }

            $title = "{$product->title}";
            $price = $product->price;

            $cart = self::getCart();

            $currency = app(CurrencyService::class)->currency;
            $cart['currency'] = $currency;

            if (isset($cart[$id])) {
                $cart[$id]['qty'] += $qty;
            } else {
                $cart[$id] = [
                    'qty' => $qty,
                    'title' => $title,
                    'alias' => $product->alias,
                    'price' => $price * $cart['currency']['value'],
                    'img' => $product->img
                ];
            }

            $cart['qty'] = isset($cart['qty']) ? $cart['qty'] + $qty : $qty;

            $productsPrice = $qty * $price * $currency['value'];
            $cart['sum'] = isset($cart['sum']) ? $cart['sum'] + $productsPrice : $productsPrice;

            Cache::put('cart', $cart, 60 * 24);
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

    public static function getCart() {
        return Cache::get('cart');
    }

    public static function clear() {
        return Cache::forget('cart');
    }

    public function getCartSum() {
        $cart = self::getCart();
        return $cart['sum'] ?? null;
    }

    public static function getCartProducts() {
        $cart = self::getCart();
        if (!$cart) {
            return null;
        }

        $products = [];

        foreach ($cart as $k => $v) {
            if ($k !== 'sum' && $k !== 'qty' && $k !== 'currency') {
                $products[$k] = $v;
            }
        }
        return $products;
    }

}
