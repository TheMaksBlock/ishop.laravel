<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\admin\OrderService;


class OrderController extends Controller {
    private $orderService;
    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index() {
        $orders = $this->orderService->getOrders();
        return view('admin.order.index', compact('orders'));
    }
}
