<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    $product = Product::where('name', 'LIKE', '%' . $request->message . '%')->first();

    if ($product) {
        $productLink = url('/product/' . $product->slug_product);

        return response()->json([
            'ai_suggest' => $aiText,
            'product_name' => $product->name,
            'product_link' => $productLink,
        ]);
    }

    return response()->json([
        'ai_suggest' => $aiText,
        'message' => 'Chưa tìm được sản phẩm phù hợp trong kho dữ liệu.',
    ]);
}

}
