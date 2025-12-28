<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $items = session('cart', []);

        if (empty($items)) {
            return redirect()->route('home')->with('error', 'Giỏ hàng trống');
        }

        return view('client.checkout.index', compact('items'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name_customer'   => 'required|string|max:255',
            'phone_customer'  => 'required|string|max:20',
            'address_detail'  => 'required|string',
            'province'        => 'required|string',
            'district'        => 'required|string',
            'ward'            => 'required|string',
            'payment_method'  => 'required|in:COD'
        ], [
            'name_customer.required'   => 'Vui lòng nhập họ tên',
            'phone_customer.required'  => 'Vui lòng nhập số điện thoại',
            'address_detail.required'  => 'Vui lòng nhập địa chỉ',
            'province.required'        => 'Vui lòng chọn Tỉnh/TP',
            'district.required'        => 'Vui lòng chọn Quận/Huyện',
            'ward.required'            => 'Vui lòng chọn Phường/Xã',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống');
        }

        DB::beginTransaction();
        try {
            // 1️⃣ TÍNH TỔNG TIỀN
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 2️⃣ TẠO ĐƠN HÀNG
            $order = Order::create([
                'name_customer'  => $request->name_customer,
                'phone_customer' => $request->phone_customer,
                'email_customer' => $request->email_customer,
                'address_detail' => $request->address_detail,
                'province'       => $request->province,
                'district'       => $request->district,
                'ward'           => $request->ward,
                'note'           => $request->note,
                'payment_method' => $request->payment_method,
                'total_price'    => $total,
                'status_order'   => '0', // 0 = pending
            ]);

            // 3️⃣ LƯU CHI TIẾT ĐƠN + TRỪ TỒN KHO
            foreach ($cart as $item) {
                $variant = ProductVariant::lockForUpdate()
                    ->find($item['id_product_variant']);

                if (!$variant) {
                    throw new \Exception('Sản phẩm "' . $item['name'] . '" không tồn tại');
                }

                if ($variant->stock < $item['quantity']) {
                    throw new \Exception('Sản phẩm "' . $item['name'] . '" không đủ tồn kho (Còn: ' . $variant->stock . ')');
                }

                OrderDetail::create([
                    'id_order'           => $order->id_order, // ✅ Sử dụng id_order
                    'id_product'         => $item['id_product'], // ✅ Thêm id_product
                    'id_product_variant' => $item['id_product_variant'],
                    'price'              => $item['price'],
                    'quantity'           => $item['quantity'],
                ]);

                // 🔥 TRỪ TỒN KHO
                $variant->decrement('stock', $item['quantity']);
            }

            // 4️⃣ XÓA GIỎ HÀNG
            session()->forget('cart');

            DB::commit();
            
            return redirect()->route('home')
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng: #' . $order->id_order);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}