<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Services\BreadCrumbsService;
use App\Services\CurrencyService;
use App\Services\RecentlyViewedService;



class ProductController extends Controller
{
    private $recentlyViewedService;
    private $breadCrumbsService;
    private $currencyService;

    public function __construct(RecentlyViewedService $recentlyViewedService,
                                BreadCrumbsService $breadCrumbsService,
                                CurrencyService $currencyService) {
        $this->recentlyViewedService = $recentlyViewedService;
        $this->breadCrumbsService = $breadCrumbsService;
        $this->currencyService = $currencyService;
    }

    public function show(Product $product){
        $gallery = Gallery::find($product->id);

        $relatedProducts = $product->relatedProducts()->get();
        $related = [];
        foreach ($relatedProducts as $prod){
            $related[] = $prod->related;
        }

        $recentlyViewed = $this->recentlyViewedService->getRecentlyViewedProducts();
        $breadCrumbs = $this->breadCrumbsService->getBreadCrumbs($product->id);
        $currencyWidget = $this->currencyService->getHtml();

        return view('product.show', compact("product",
            "gallery","related", "recentlyViewed", "breadCrumbs","currencyWidget"));
    }
}
