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

    public function getOrders($perpage = 10) {

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

        return $query->paginate($perpage);
    }
}
