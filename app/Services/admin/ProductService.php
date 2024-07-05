<?php

namespace App\Services\admin;

use App\Models\AttributeProduct;
use App\Models\RelatedProduct;
use Illuminate\Support\Facades\DB;

class ProductService {

    public function editRelated($newRelated,$productId){
        if($newRelated){
            $related = RelatedProduct::where("product_id", $productId)
                ->pluck('related_id')
                ->toArray();

            $toAdd = array_diff($newRelated,$related);
            $toDelete = array_diff($related, $toAdd);

            foreach ($toAdd as $relatedProductId) {
                RelatedProduct::create([
                    'product_id' => $productId,
                    'related_id' => $relatedProductId
                ]);
            }

            RelatedProduct::where("product_id", $productId)
                ->whereIn("related_id", $toDelete)
                ->delete();
        }
    }

    public function editAttrs($newAttrs, $productId){
        if($newAttrs){
            $attrs = AttributeProduct::where("product_id", $productId)
                ->pluck('attr_id')
                ->toArray();

            $toAdd = array_diff($newAttrs,$attrs);
            $toDelete = array_diff($attrs, $toAdd);

            foreach ($toAdd as $attrId) {
                AttributeProduct::create([
                    'product_id' => $productId,
                    'attr_id' => $attrId
                ]);
            }

            AttributeProduct::where("product_id", $productId)
                ->whereIn("attr_id", $toDelete)
                ->delete();
        }
    }


}
