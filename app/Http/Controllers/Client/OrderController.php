<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    /**
     * ============================
     * GET: HIỂN THỊ TRANG CHECKOUT
     * ============================
     */
public function showCheckout()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('client.cart');
    }

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return view('client.checkout.index', compact('cart', 'total'));
}




    /**
     * ============================
     * POST: XỬ LÝ ĐẶT HÀNG + THANH TOÁN COD
     * ============================
     */
public function checkout(Request $request)
{
    $request->validate([
        'name_customer'  => 'required',
        'phone_customer' => 'required',
        'address_detail' => 'required',
        'province'       => 'required',
        'district'       => 'required',
        'ward'           => 'required',
    ]);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('client.cart');
    }

    DB::beginTransaction();

    try {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'name_customer' => $request->name_customer,
            'phone_customer'=> $request->phone_customer,
            'email_customer'=> $request->email_customer,
            'province'      => $request->province,
            'district'      => $request->district,
            'ward'          => $request->ward,
            'address_detail'=> $request->address_detail,
            'total_amount'  => $total,
            'status_order'  => 0,
            'code_order'    => '#'.rand(100000,999999),
        ]);

        foreach ($cart as $item) {
            OrderDetail::create([
                'id_order'   => $order->id_order,
                'id_product' => $item['id_product'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        session()->forget('cart');
        DB::commit();

        return redirect()->route('home')
            ->with('success','Đặt hàng thành công');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error','Có lỗi xảy ra');
    }
}

}
