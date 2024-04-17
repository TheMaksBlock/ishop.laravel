<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Services\BreadCrumbsService;
use App\Services\RecentlyViewedService;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    private $recentlyViewedService;
    private $breadCrumbsService;
    public function __construct(RecentlyViewedService $recentlyViewedService, BreadCrumbsService $breadCrumbsService) {
        $this->recentlyViewedService = $recentlyViewedService;
        $this->breadCrumbsService = $breadCrumbsService;
    }

    public function show(Product $product){
        $gallery = Gallery::find($product->id);

        $relatedProducts = $product->relatedProducts()->get();
        $related = [];
        foreach ($relatedProducts as $prod){
            $related[] = $prod->related;
        }

        $recentlyViewed = $this->recentlyViewedService->getRecentlyViewedProducts();
        $this->recentlyViewedService->setRecentlyViewed($product->id);

        $breadCrumbs = $this->breadCrumbsService->getBreadCrumbs($product->id);

        return view('product.show', compact("product", "gallery","related", "recentlyViewed", "breadCrumbs"));
    }
}
