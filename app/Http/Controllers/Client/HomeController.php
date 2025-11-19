<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;




class HomeController extends Controller
{
   
public function index()
{
    // Danh mục icon
    $categories = Category::where('status_category', 1)
                    ->orderBy('id_category')
                    ->get();

    // Banner (nếu bạn có bảng tb_banner)
    $banners = \DB::table('tb_banner')
                ->where('status', 1)
                ->orderBy('sort', 'ASC')
                ->get();

    // Bộ sưu tập lookbook (nếu có bảng collection)
    $collections = \DB::table('tb_collection')
                    ->where('status', 1)
                    ->get();

    // Sản phẩm mới
    $new_products = Product::orderBy('id_product', 'DESC')
                        ->take(10)
                        ->get();

    // Sản phẩm bán chạy
    $best_sellers = Product::orderBy('view_product', 'DESC')
                        ->take(10)
                        ->get();

    return view('client.home.index', compact(
        'categories',
        'banners',
        'collections',
        'new_products',
        'best_sellers'
    ));
}
public function search(Request $request)
{
    $keyword = $request->keyword;

    $products = Product::where('name_product', 'LIKE', "%$keyword%")
        ->orWhere('describe_product', 'LIKE', "%$keyword%")
        ->paginate(24);

    return view('client.search.index', compact('products', 'keyword'));
}


}
