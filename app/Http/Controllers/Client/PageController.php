<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class PageController extends Controller
{
public function storeSystem()
{
    $stores = [
        'ha_noi' => [
            [
                'name' => 'Sweetie 140 Cầu Giấy',
                'address' => '140 Cầu Giấy, Hà Nội',
                'phone' => '0966313528',
                'map' => 'https://www.google.com/maps?q=140%20C%E1%BA%A7u%20Gi%E1%BA%A5y,%20H%C3%A0%20N%E1%BB%99i&output=embed'
            ],
            [
                'name' => 'Sweetie Times City',
                'address' => 'Times City, Hai Bà Trưng, Hà Nội',
                'phone' => '0966313528',
                'map' => 'https://www.google.com/maps?q=Times%20City%20Ha%20Noi&output=embed'
            ],
        ],

        'hai_phong' => [
            [
                'name' => 'Sweetie An Lão',
                'address' => 'An Lão, Hải Phòng',
                'phone' => '0966313528',
                'map' => 'https://www.google.com/maps?q=An%20Lao%20Hai%20Phong&output=embed'
            ],
        ],
    ];

    return view('client.pages.store-system', compact('stores'));
}
public function shippingPolicy()
{
    $suggestProducts = Product::where('status_product', 1)
        ->orderBy('view_product', 'desc')
        ->limit(3)
        ->get();

    return view('client.pages.shipping-policy', compact('suggestProducts'));
}
}
