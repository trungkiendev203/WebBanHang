<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerAddress;
use App\Services\MomoService;



class CheckoutController extends Controller
{
public function checkout()
{
    $items = session('cart', []);
        
    if (empty($items)) {
        return redirect()->route('home')->with('error', 'Giỏ hàng trống');
    }

$user = Auth::guard('customer')->user();

$address = null;

if ($user) {
    $address = CustomerAddress::where('id_customer', $user->id_customer)
        ->where('is_default', 1)
        ->first();
}


    return view('client.checkout.index', compact('items', 'user', 'address'));
}

public function store(Request $request, MomoService $momo)
{
    $request->validate([
        'name_customer'   => 'required|string|max:255',
        'phone_customer'  => 'required|string|max:20',
        'address_detail'  => 'required|string',
        'province'        => 'required|string',
        'district'        => 'required|string',
        'ward'            => 'required|string',
        'payment_method'  => 'required|in:COD,MOMO'
    ]);

    $cart = session('cart', []);
    if (empty($cart)) {
        return back()->with('error', 'Giỏ hàng trống');
    }

    DB::beginTransaction();
    try {
        // 1️⃣ Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 2️⃣ Tạo đơn hàng (CHƯA trừ kho)
$order = Order::create([
    'id_customer'   => Auth::guard('customer')->id(),
    'name_customer' => $request->name_customer,
    'phone_customer'=> $request->phone_customer,
    'email_customer'=> $request->email_customer,
    'address_detail'=> $request->address_detail,
    'province'      => $request->province,
    'district'      => $request->district,
    'ward'          => $request->ward,
    'payment_method'=> $request->payment_method,
    'payment_status'=> 'unpaid',
    'total_amount'  => $total,

    // 🔥 SỬA DÒNG NÀY
    'status_order'  => $request->payment_method === 'MOMO' ? 9 : 0,
]);


        // 3️⃣ Lưu order_detail (KHÔNG trừ kho với MOMO)
        foreach ($cart as $item) {
            OrderDetail::create([
                'id_order'           => $order->id_order,
                'id_product'         => $item['id_product'],
                'id_product_variant' => $item['id_product_variant'],
                'price'              => $item['price'],
                'quantity'           => $item['quantity'],
            ]);
        }

        DB::commit();

        // ================= COD =================
        if ($request->payment_method === 'COD') {

            foreach ($cart as $item) {
                $variant = ProductVariant::lockForUpdate()
                    ->find($item['id_product_variant']);

                if ($variant->stock < $item['quantity']) {
                    throw new \Exception('Không đủ tồn kho');
                }

                $variant->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');

            return redirect()->route('home')
                ->with('success', 'Đặt hàng COD thành công! Mã đơn #' . $order->id_order);
        }

        // ================= MOMO =================
        $response = $momo->createPayment([
            'order_id'   => $order->id_order,
            'amount'     => $total,
            'order_info' => 'Thanh toán đơn hàng #' . $order->id_order,
        ]);

        if (isset($response['payUrl'])) {
            return redirect()->away($response['payUrl']);
        }

        throw new \Exception('Không tạo được thanh toán MoMo');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

}