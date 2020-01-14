<?php

namespace App\Observers;

use App\Models\Product\Product;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    public function created(Product $product)
    {
      if(!is_null($product->parent_id)){
          $product->parent()->increment('price', $product->price);
      }
    }

    public function deleted(Product $product)
    {
        $parent = Product::findOrFail($product->parent_id);
        $parent->price -= $product->price;
        $parent->save();
    }
}
