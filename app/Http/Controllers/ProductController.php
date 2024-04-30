<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Services\BreadCrumbsService;
use App\Services\CategoriesMenuService;
use App\Services\CurrencyService;
use App\Services\RecentlyViewedService;



class ProductController extends Controller
{
    private $recentlyViewedService;
    private $breadCrumbsService;
    private $currencyService;
    private $categoriesMenuService;

    public function __construct(RecentlyViewedService $recentlyViewedService,
                                BreadCrumbsService $breadCrumbsService,
                                CurrencyService $currencyService, CategoriesMenuService $categoryMenu) {
        $this->recentlyViewedService = $recentlyViewedService;
        $this->breadCrumbsService = $breadCrumbsService;
        $this->currencyService = $currencyService;
        $this->categoriesMenuService = $categoryMenu;
    }

    public function show(Product $product){
        $gallery = Gallery::where('product_id',$product->id)->get();

        $relatedProducts = $product->relatedProducts()->get();
        $related = [];
        foreach ($relatedProducts as $prod){
            $related[] = $prod->related;
        }

        $recentlyViewed = $this->recentlyViewedService->getRecentlyViewedProducts($product->id);
        $this->recentlyViewedService->setRecentlyViewed($product->id);
        $breadCrumbs = $this->breadCrumbsService->getBreadCrumbs($product->category_id, $product->title);
        $currencyWidget = $this->currencyService->getHtml();
        $currency = $this->currencyService->currency;
        $menu = $this->categoriesMenuService->get();
        return view('product.show', compact("product",
            "gallery","related", "recentlyViewed", "breadCrumbs","currencyWidget", "currency","menu"));
    }
}
