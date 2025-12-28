<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

    // Thêm vào giỏ hàng
    public function add(Request $request)
    {
        if (!$request->id_product_variant) {
            return back()->with('error', 'Vui lòng chọn size và màu');
        }

        $quantity = max((int)$request->quantity, 1);

        $variant = ProductVariant::findOrFail($request->id_product_variant);
        $product = Product::select(
                'id_product',
                'name_product',
                'price_product',
                'saleprice_product',
                'image'
            )
            ->where('id_product', $variant->id_product)
            ->firstOrFail();

        $price = $product->saleprice_product > 0
            ? $product->saleprice_product
            : $product->price_product;

        $cart = session()->get('cart', []);

        if (isset($cart[$variant->id_product_variant])) {
            $cart[$variant->id_product_variant]['quantity'] += $quantity;
        } else {
            $cart[$variant->id_product_variant] = [
                'id_product_variant' => $variant->id_product_variant,
                'id_product' => $product->id_product,
                'name' => $product->name_product,
                'price' => $price,
                'size' => $variant->size,
                'color' => $variant->color,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('client.cart')->with('success', 'Đã thêm vào giỏ hàng');
    }

    // Mua ngay = add + checkout
public function buyNow(Request $request)
{
    $this->add($request); // thêm vào session('cart')
    return redirect()->route('client.checkout');
}


    // Trang checkout
    public function checkout()
    {
        $items = session()->get('cart', []);
        return view('client.checkout', compact('items'));
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $variantId = $request->variant_id;
        $change = (int)$request->change;

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $change;
            if ($cart[$variantId]['quantity'] <= 0) {
                unset($cart[$variantId]);
            }
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'new_quantity' => $cart[$variantId]['quantity'] ?? 0
        ]);
    }

    // Xóa sản phẩm
    public function delete($variantId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Đã xóa sản phẩm');
    }
}
