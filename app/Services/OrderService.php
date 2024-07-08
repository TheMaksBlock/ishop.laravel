<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderService {
    public function saveOrder($note, $currency) {
        $cart = (new CartService())->getCart();
        if ($cart["items"]->isEmpty()) {
            return null;
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->note = $note;
        $order->currency = $currency['code'];
        $order->save();

        $this->saveOrderProduct($order->id, $cart["items"]);
        (new CartService())->clear();
        return $order->id;
    }

    public function saveOrderProduct($order_id, $products) {
        foreach ($products as $product) {
            $order_product = new OrderProduct();
            $order_product->order_id = $order_id;
            $order_product->product_id = (int)$product->id;
            $order_product->qty = $product->quantity;
            $order_product->title = $product->title;
            $order_product->price = $product->price;
            $order_product->save();
        }
    }
}
