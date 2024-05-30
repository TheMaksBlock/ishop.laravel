<?php

namespace App\Services\admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use function PHPUnit\Framework\isEmpty;

class OrderService {


    public function __construct() {
    }

    public function getOrders($confirmed_orders = '',$perpage = 10) {

        $query = Order::query();
        $query = $query->select(
            'order.id',
            'order.user_id',
            'order.status',
            'order.date',
            'order.update_at',
            'order.currency',
            'order.note',
            'users.name',
            DB::raw('ROUND(SUM(order_product.price), 2) AS sum')
        )
            ->leftJoin('order_product', 'order_product.order_id', '=', 'order.id')
            ->leftJoin('product', 'product.id', '=', 'order_product.product_id')
            ->leftJoin('users', 'users.id', '=', 'order.user_id')
            ->groupBy(
                'order.id',
                'order.user_id',
                'order.status',
                'order.date',
                'order.update_at',
                'order.currency',
                'order.note',
                'users.name'
            )
            ->orderBy('order.id');

        if($confirmed_orders){
            $query=$query->where("order.status = '0'");
        }

        return $query->paginate($perpage);
    }

    public function getOrder($id) {
        return Order::select(
            'order.id',
            'order.user_id',
            'order.status',
            'order.date',
            'order.update_at',
            'order.currency',
            'order.note',
            'users.name',
            DB::raw('ROUND(SUM(order_product.price), 2) AS sum')
        )
            ->leftJoin('order_product', 'order_product.order_id', '=', 'order.id')
            ->leftJoin('product', 'product.id', '=', 'order_product.product_id')
            ->leftJoin('users', 'users.id', '=', 'order.user_id')
            ->where('order.id', '=', $id)
            ->groupBy(
                'order.id',
                'order.user_id',
                'order.status',
                'order.date',
                'order.update_at',
                'order.currency',
                'order.note',
                'users.name'
            )
            ->orderBy('order.id')->first();
    }

    public function delete($id) {
        $order = Order::find($id);
        if($order){
            $order->delete();
            return true;
        }
        return false;
    }

    public function change($id, $status) {
        $order = Order::find($id);
        if($order){
            $order->status = $status;
            $order->update_at = date("Y-m-d H:i:s");
            $order->save();
            return true;
        }
        return false;
    }
}
