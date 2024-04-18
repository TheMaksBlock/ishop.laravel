<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Services\BreadCrumbsService;
use App\Services\CurrencyService;
use App\Services\RecentlyViewedService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
    }

    public function index(){
        $brands = Brand::take(3)->get();
        $hits =Product::where('hit', 1)
            ->where('status', "1")
            ->take(8)
            ->get();


        $currencyWidget = $this->currencyService->getHtml();
        return view('main.index', compact("brands", "hits", "currencyWidget"));
    }
}
