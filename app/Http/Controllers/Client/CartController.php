<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

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
        // DEBUG: Xem dữ liệu được gửi lên
        \Log::info('Add to cart request:', [
            'id_product_variant' => $request->id_product_variant,
            'quantity' => $request->quantity,
            'all_request' => $request->all()
        ]);

        if (!$request->id_product_variant) {
            return back()->with('error', 'Vui lòng chọn size và màu');
        }

        // Validate quantity
        $quantity = (int) $request->quantity;
        if ($quantity < 1) {
            $quantity = 1;
        }

        $variant = ProductVariant::findOrFail($request->id_product_variant);
        $product = Product::select('id_product', 'name_product', 'price_product', 'saleprice_product', 'image')
            ->where('id_product', $variant->id_product)
            ->firstOrFail();

        $cart = session()->get('cart', []);

        // DEBUG: Xem trạng thái giỏ hàng trước khi thêm
        \Log::info('Cart before add:', [
            'variant_id' => $variant->id_product_variant,
            'exists' => isset($cart[$variant->id_product_variant]),
            'old_quantity' => $cart[$variant->id_product_variant]['quantity'] ?? 0
        ]);

        if (isset($cart[$variant->id_product_variant])) {
            // Sản phẩm đã có trong giỏ -> CỘNG THÊM
            $cart[$variant->id_product_variant]['quantity'] += $quantity;
            
            \Log::info('Product exists, updated quantity:', [
                'new_quantity' => $cart[$variant->id_product_variant]['quantity']
            ]);
        } else {
            // Sản phẩm chưa có -> THÊM MỚI
            $cart[$variant->id_product_variant] = [
                'id_product' => $product->id_product,
                'name' => $product->name_product,
                'price' => $product->saleprice_product > 0
                            ? $product->saleprice_product
                            : $product->price_product,
                'size' => $variant->size,
                'color' => $variant->color,
                'quantity' => $quantity,
                'image' => $product->image
            ];
            
            \Log::info('New product added:', [
                'quantity' => $quantity
            ]);
        }

        session()->put('cart', $cart);

        // DEBUG: Xem giỏ hàng sau khi lưu
        \Log::info('Cart after save:', [
            'cart_content' => session('cart')
        ]);

        return redirect()->route('client.cart')->with('success', 'Đã thêm vào giỏ hàng');
    }

    // Cập nhật số lượng
    public function update(Request $request)
    {
        $cart = session('cart', []);
        $variantId = $request->variant_id;
        $change = (int) $request->change;
        
        // DEBUG: Xem giá trị
        \Log::info('Update cart:', [
            'variant_id' => $variantId,
            'old_quantity' => $cart[$variantId]['quantity'] ?? 'not found',
            'change' => $change
        ]);
        
        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $change;
            
            // DEBUG: Xem giá trị sau khi cập nhật
            \Log::info('After update:', [
                'new_quantity' => $cart[$variantId]['quantity']
            ]);
            
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

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }
}