<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function detail($slug)
    {
        $product = Product::where('slug_product', $slug)->firstOrFail();

        return view('client.product.detail', compact('product'));
    }
    public function show($id)
    {
       $product = Product::Where('slug_product', $id)->firstOrFail();

        return view('client.product.show', compact('product'));
    }
}
