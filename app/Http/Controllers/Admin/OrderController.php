<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class OrderController extends Controller
{
    // ==========================
    // ➕ FORM THÊM MỚI HÓA ĐƠN
    // ==========================
    public function create()
    {
        $products = Product::select(
            'id_product',
            'code_product',
            'name_product',
            'price_product',
            'saleprice_product',
            'image'
        )->get();

        return view('admin.order.create', compact('products'));
    }

    // ==========================
    // 💾 LƯU HÓA ĐƠN MỚI
    // ==========================
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1️⃣ Lưu thông tin hóa đơn
            $order = Order::create([
                'code_order' => '#'.rand(1000000,9999999),
                'name_customer' => $request->name_customer,
                'email_customer' => $request->email_customer,
                'phone_customer' => $request->phone_customer,
                'province' => $request->province,
                'district' => $request->district,
                'ward' => $request->ward,
                'address_detail' => $request->address_detail,
                'order_date' => now(),
                'total_amount' => 0,
                'status_order' => 0,
            ]);

            // 2️⃣ Lưu chi tiết từng sản phẩm
            $total = 0;
            if ($request->has('products')) {
                foreach ($request->products as $item) {
                    $product = Product::find($item['id']);
                    if (!$product) continue;

                    // Dùng giá khuyến mãi nếu có
                    $price = $product->saleprice_product > 0 ? $product->saleprice_product : $product->price_product;
                    $subtotal = $price * $item['quantity'];
                    $total += $subtotal;

                    OrderDetail::create([
                        'id_order' => $order->id_order,
                        'id_product' => $product->id_product,
                        'quantity' => $item['quantity'],
                        'price' => $price,
                    ]);
                }
            }

            // 3️⃣ Cập nhật tổng tiền hóa đơn
            $order->update(['total_amount' => $total]);

            DB::commit();

            // 4️⃣ Trả về trang hiện tại + popup thông báo
            return back()->with('success', 'Tạo hóa đơn thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }
}
