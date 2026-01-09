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
    public function add(Request $request)
{
    $result = $this->addToCartLogic($request);

    if (isset($result['error'])) {
        return back()->with('error', $result['error']);
    }

    return redirect()->route('client.cart')->with('success', 'Đã thêm vào giỏ hàng');
}
public function buyNow(Request $request)
{
    $result = $this->addToCartLogic($request);

    if (isset($result['error'])) {
        return back()->with('error', $result['error']);
    }

    return redirect()->route('client.checkout');
}


private function addToCartLogic(Request $request)
{
    if (!$request->id_product_variant) {
        return ['error' => 'Vui lòng chọn size và màu'];
    }

    $quantity = max((int)$request->quantity, 1);
    $variant = ProductVariant::findOrFail($request->id_product_variant);

    if ($variant->stock < $quantity) {
        return ['error' => 'Sản phẩm không đủ tồn kho'];
    }

    $product = Product::where('id_product', $variant->id_product)->firstOrFail();
    $price = $product->saleprice_product ?: $product->price_product;

    $cart = session()->get('cart', []);

    if (isset($cart[$variant->id_product_variant])) {
        $newQty = $cart[$variant->id_product_variant]['quantity'] + $quantity;
        if ($newQty > $variant->stock) {
            return ['error' => 'Số lượng vượt quá tồn kho'];
        }
        $cart[$variant->id_product_variant]['quantity'] = $newQty;
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
    return ['success' => true];
}


    // Trang checkout
    public function checkout()
    {
        $items = session()->get('cart', []);
        
        // ✅ Kiểm tra giỏ hàng trống
        if (empty($items)) {
            return redirect()->route('client.home')->with('error', 'Giỏ hàng trống');
        }
        
        return view('client.checkout', compact('items'));
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $variantId = $request->variant_id;
        $change = (int)$request->change;

        if (!isset($cart[$variantId])) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
        }

        // ✅ Lấy variant để check stock
        $variant = ProductVariant::find($variantId);
        if (!$variant) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
        }

        $newQty = $cart[$variantId]['quantity'] + $change;

        // ✅ Kiểm tra vượt tồn kho
        if ($newQty > $variant->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Vượt quá tồn kho'
            ]);
        }

        // ✅ Xóa nếu quantity <= 0
        if ($newQty <= 0) {
            unset($cart[$variantId]);
            session()->put('cart', $cart);
            return response()->json([
                'success' => true,
                'new_quantity' => 0,
                'deleted' => true
            ]);
        }

        $cart[$variantId]['quantity'] = $newQty;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'new_quantity' => $newQty
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