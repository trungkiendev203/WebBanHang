<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
public function show($slug)
{
    $category = Category::where('slug_category', $slug)->firstOrFail();
    if ($slug == 'ao') {
        $ao_ids = Category::whereIn('slug_category', ['ao', 'ao-khoac-cong-so'])
                          ->pluck('id_category');

        $products = Product::whereIn('id_category', $ao_ids)
                            ->orderBy('id_product', 'DESC')
                            ->paginate(24);

        $countProducts = Product::whereIn('id_category', $ao_ids)->count();
    } 
    else {
        // Các danh mục khác: lấy bình thường
        $products = Product::where('id_category', $category->id_category)
                           ->orderBy('id_product', 'DESC')
                           ->paginate(24);

        $countProducts = Product::where('id_category', $category->id_category)->count();
    }
    $counts = [];
    foreach (Category::all() as $cat) {
        $counts[$cat->slug_category] = Product::where('id_category', $cat->id_category)->count();
    }

    return view('client.category.index', compact(
        'category',
        'products',
        'countProducts',
        'counts'
    ));
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

        return view('client.category.index', [
            'category' => $category,
            'products' => $products,
            'countProducts' => $products->total(),
            'counts' => [] // tránh lỗi khi view require biến counts
        ]);
    }
}
