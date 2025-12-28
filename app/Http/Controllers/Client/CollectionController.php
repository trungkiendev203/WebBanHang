<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Support\Facades\DB;


class CollectionController extends Controller
{
public function show($slug)
{
    $collection = Collection::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    $products = $collection->products()
        ->where('status_product', 1)
        ->with(['images'])
        ->paginate(12);

    // 🔥 THÊM ĐOẠN NÀY
    foreach ($products as $product) {
        $product->total_sold = DB::table('tb_order_detail')
            ->where('id_product', $product->id_product)
            ->sum('quantity');
    }

    return view('client.collection.show', compact('collection', 'products'));
}

}


