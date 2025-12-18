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
       $rawSizes = $product->size_product; // Giả sử 'sizes' là một thuộc tính trả về chuỗi kích thước
       $sizes = []; // Khởi tạo mảng kích thước
       foreach (explode(',', $rawSizes) as $size_product) {
            [$size, $quantity] = array_pad(explode(':', $size_product), 2, null);
            $sizes[$size] = (int)($quantity??0);
       }
       

        return view('client.product.show', compact('product', 'sizes'));
    }
}
