<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductShowController extends Controller
{
    public function __invoke(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
