<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $brands = Brand::take(3)->get();
        $hits =Product::where('hit', 1)
            ->where('status', "1")
            ->take(8)
            ->get();

        return view('index', compact("brands", "hits"));
    }
}
