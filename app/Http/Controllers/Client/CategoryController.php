<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug)
    {
        
        // Lấy danh mục theo slug
        $category = Category::where('slug_category', $slug)->firstOrFail();

        // Lấy sản phẩm thuộc danh mục
        $products = Product::where('id_category', $category->id_category)
                           ->orderBy('id_product', 'DESC')
                           ->paginate(24);
 $countProducts = Product::where('id_category', $category->id_category)->count();
        return view('client.category.index', compact('category', 'products', 'countProducts'));
    } 
    public function sale()
{
    $category = (object)[
        'name_category' => 'SALE',
        'slug_category' => 'sale'
    ];

    $products = Product::where('saleprice_product', '>', 0)
                ->orderBy('id_product', 'desc')
                ->paginate(20);

    return view('client.category.index', compact('category', 'products'));
}

}
