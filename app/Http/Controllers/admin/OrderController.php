<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\admin\OrderService;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;


class OrderController extends Controller {
    private $orderService;
    private $perpage = 10;

    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index() {
        $orders = $this->orderService->getOrders();
        return view('admin.order.index', compact('orders'));
    }

    public function show($id) {
        $order = $this->orderService->getOrder($id);
        if(!$order) {
            abort(404);
        }
        $products = $order->orderProducts()->get();
        return view('admin.order.show', compact('order', 'products'));
    }

    public function delete(Request $request) {
        $success = $this->orderService->delete($request->get('id'));

        if ($success) {
            return redirect()->route("admin.order.index")->with("success", "Заказ удалён");
        }

        return redirect()->route("admin.order.index")->withErrors(["error" => "Ошибка удаления"]);
    }

    public function change(Request $request){
        $success = $this->orderService->change($request->get('id'),$request->get('status'));

        if ($success) {
            return redirect()->route("admin.order.index")->with("success", "Изменения сохранены");
        }

        return redirect()->route("admin.order.index")->withErrors(["error" => "Ошибка изменения"]);
    }
}
