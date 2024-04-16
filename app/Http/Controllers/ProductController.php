<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    public function show(Product $product){
        $gallery = Gallery::find($product->id);

        $relatedProducts = $product->relatedProducts()->get();
        $related = [];
        foreach ($relatedProducts as $prod){
            $related[] = $prod->related;
        }

        Session::put("");

        return view('product.show', compact("product", "gallery","related"));
    }
}
