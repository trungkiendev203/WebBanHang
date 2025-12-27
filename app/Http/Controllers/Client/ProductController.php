<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    // ✅ XÓA method detail() CŨ - KHÔNG CẦN NỮA
    
    // ✅ CHỈ GIỮ LẠI METHOD show() - ĐÃ SỬA
    public function show($slug)
    {   
        // Load product với quan hệ images
        $product = Product::with('images')
                          ->where('slug_product', $slug)
                          ->firstOrFail();

        // LẤY TOÀN BỘ VARIANT
        $variants = ProductVariant::where('id_product', $product->id_product)->get();
        
        // LẤY MÀU DUY NHẤT
        $colors = $variants->pluck('color')->unique()->values();

        // LẤY SIZE + TỔNG STOCK
        $sizes = $variants->groupBy('size')->map(function ($group) {
            return $group->sum('stock');
        });
        
        // SẢN PHẨM GỢI Ý
        $suggestProducts = Product::where('status_product', 1)
            ->where('id_product', '!=', $product->id_product)
            ->orderBy('view_product', 'desc')
            ->limit(6)
            ->get();

        // ✅ QUAN TRỌNG: Đổi view từ 'client.product.show' sang 'client.product.detail'
        return view('client.product.show', compact(
            'product',
            'variants',
            'sizes',
            'suggestProducts',
            'colors'
        ));
    }

    public function suggestProduct(Request $request)
    {
        $prompt = "Khách hàng mô tả nhu cầu: " . $request->message;

        $aiResponse = Http::withToken(env('OPENAI_API_KEY'))->post(
            'https://api.openai.com/v1/chat/completions',
            [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]
        );

        $aiText = $aiResponse->json()['choices'][0]['message']['content'] ?? '';

        $product = Product::where('name_product', 'LIKE', '%' . $request->message . '%')->first();

        if ($product) {
            $productLink = url('/product/' . $product->slug_product);

            return response()->json([
                'ai_suggest' => $aiText,
                'product_name' => $product->name_product,
                'product_link' => $productLink,
            ]);
        }

        return response()->json([
            'ai_suggest' => $aiText,
            'message' => 'Chưa tìm được sản phẩm phù hợp trong kho dữ liệu.',
        ]);
    }
}