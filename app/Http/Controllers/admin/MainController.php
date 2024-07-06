<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;


class MainController extends Controller {
    public function __construct() {
    }

    public function index() {
        $countOrders = Order::where("status", "0")->count();
        $countUsers = User::where("role", "user")->count();
        $countProducts = Product::where("status", "1")->count();
        $countCategories = Category::all()->count();

        return view('admin.main.index',
            compact('countOrders', 'countUsers', 'countProducts', 'countCategories'));
    }
}
