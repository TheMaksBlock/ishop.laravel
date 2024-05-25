<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OrderService {
    public function saveOrder($note, $currency)
    {
        $products = CartService::getCartProducts();
        if(!$products){
            return null;
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->note = $note;
        $order->currency = $currency['code'];
        $order->save();

        $this->saveOrderProduct($order->id);
        CartService::clear();
        return $order->id;
    }

    public function saveOrderProduct($order_id, $products)
    {
        foreach ($products as $product_id => $product) {
            $order_product = new OrderProduct();
            $order_product->order_id = $order_id;
            $order_product->product_id = (int)$product_id;
            $order_product->qty = $product['qty'];
            $order_product->title = $product['title'];
            $order_product->price = $product['price'];
            $order_product->save();
        }
    }
}
