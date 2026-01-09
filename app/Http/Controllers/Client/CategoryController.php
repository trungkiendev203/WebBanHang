<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
public function show(Request $request, $slug)
{
    
    $category = Category::where('slug_category', $slug)->firstOrFail();
    

    // Query gốc
$categoryIds = Category::where('parent_id', $category->id_category)
    ->pluck('id_category')
    ->toArray();

// thêm chính nó (trường hợp là danh mục con)
$categoryIds[] = $category->id_category;

$query = Product::whereIn('id_category', $categoryIds)
    ->where('status_product', 1)
    ->withSum('orderDetails as sold', 'quantity');



    // 👉 LOGIC LỌC GIÁ
if ($request->filled('price')) {
    $price = (int) $request->price;

    // Slider đang dùng đơn vị nghìn
    if ($price < 1000) {
        $price = $price * 1000;
    }

    $query->whereRaw(
        'IF(saleprice_product > 0, saleprice_product, price_product) <= ?',
        [$price]
    );
}


if ($request->filled('sort')) {
    switch ($request->sort) {
        case 'best_seller':
            // đã có withSum('orderDetails as sold')
            $query->orderByDesc('sold');
            break;

        case 'price_asc':
            $query->orderByRaw(
                'IF(saleprice_product > 0, saleprice_product, price_product) ASC'
            );
            break;

        case 'price_desc':
            $query->orderByRaw(
                'IF(saleprice_product > 0, saleprice_product, price_product) DESC'
            );
            break;

        case 'name_asc':
            $query->orderBy('name_product', 'ASC');
            break;

        default: // newest
            $query->orderByDesc('id_product');
    }
} else {
    // mặc định
    $query->orderByDesc('id_product');
}
// 🔍 LOGIC TÌM KIẾM (ĐẶT TRƯỚC paginate)
if ($request->filled('keyword')) {
    $keyword = trim($request->keyword);

    $query->where(function ($q) use ($keyword) {
        $q->where('name_product', 'LIKE', "%{$keyword}%")
          ->orWhere('code_product', 'LIKE', "%{$keyword}%")
          ->orWhere('describe_product', 'LIKE', "%{$keyword}%");
    });
}

    // Lấy dữ liệu
$products = $query->paginate(24)
    ->appends($request->query());

    if ($request->ajax()) {
    return view('client.category._products', compact('products'))->render();
}

    $countProducts = $products->total();

    // Đếm số lượng theo category (sidebar)
    $counts = [];
foreach (Category::all() as $cat) {
    $ids = Category::where('parent_id', $cat->id_category)
        ->pluck('id_category')
        ->toArray();

    $ids[] = $cat->id_category;

    $counts[$cat->slug_category] = Product::whereIn('id_category', $ids)
        ->where('status_product', 1)
        ->count();
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
