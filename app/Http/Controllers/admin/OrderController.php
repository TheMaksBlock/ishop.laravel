<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\admin\OrderService;
use Illuminate\Http\Request;


class OrderController extends Controller {
    private $orderService;
    private $perpage;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index() {
        $orders = $this->orderService->getOrders();
        return view('admin.order.index', compact('orders'));
    }

    public function show($id) {
        $order = $this->orderService->getOrder($id);
        return view('admin.order.show', compact('order'));
    }

    public function delete(Request $request) {
        $success = $this->orderService->delete($request->get('id'));

        if ($success) {
            return redirect()->route("admin.order.index")->with("success", "Заказ удалён");
        }

        return redirect()->route("admin.order.index")->withErrors(["error" => "Ошибка удаления"]);
    }
}
