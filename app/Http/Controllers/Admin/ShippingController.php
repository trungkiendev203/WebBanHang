<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index()
    {
        $orders = DB::table('tb_order')
            ->whereIn('status_order', ['1','2']) // 1: đã xác nhận, 2: đang giao
            ->orderByDesc('id_order')
            ->get();

        return view('admin.shipping.index', compact('orders'));
    }

    public function pickup($id)
    {
        $order = DB::table('tb_order')->where('id_order', $id)->first();
        if (!$order || $order->status_order != '1') {
            return back()->with('error', 'Đơn chưa ở trạng thái đã xác nhận.');
        }

        DB::table('tb_order')->where('id_order', $id)->update([
            'status_order'  => '2',
            'shipping_unit' => 'GHTK',
            'shipping_code' => 'MOCK-' . rand(100000, 999999),
            'picked_up_at'  => now(),
            'updated_at'    => now(),
        ]);

        return back()->with('success', 'Đã cập nhật: Đã lấy hàng / Đang giao.');
    }

    public function delivered($id)
    {
        $order = DB::table('tb_order')->where('id_order', $id)->first();
        if (!$order || $order->status_order != '2') {
            return back()->with('error', 'Đơn chưa ở trạng thái đang giao.');
        }

        DB::table('tb_order')->where('id_order', $id)->update([
            'status_order' => '3',
            'delivered_at' => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', 'Đã giao thành công.');
    }
}
