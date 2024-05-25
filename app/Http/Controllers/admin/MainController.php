<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\BreadCrumbsService;
use App\Services\CartService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use App\Services\RecentlyViewedService;
use Illuminate\Http\Request;
use RedBeanPHP\R;

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
