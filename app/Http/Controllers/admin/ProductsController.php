<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\admin\OrderService;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;


class ProductsController extends Controller {
    private $orderService;
    private $perpage = 10;

    public function __construct() {
    }

    public function index() {
        $products = Product::with('category')->orderBy('title')->paginate($this->perpage);
        return view('admin.products.index', compact('products'));
    }
}
