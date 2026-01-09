<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use Illuminate\Http\Request;

class BillController extends Controller
{

    public function index()
    {
        $bills = Bill::with('order')
            ->orderByDesc('id_bill')
            ->get();

        return view('admin.bill.index', compact('bills'));
    }
    public function show($id)
    {
        $bill = Bill::with(['order.orderDetails.product'])
            ->findOrFail($id);

        return view('admin.bill.show', compact('bill'));
    }

    public function update($id)
    {
        $bill = Bill::with('order')->findOrFail($id);

        // Chặn update tay với MOMO
        if ($bill->order && strtoupper($bill->order->payment_method) === 'MOMO') {
            return back()->with('error', 'Đơn MoMo sẽ tự cập nhật khi thanh toán (IPN).');
        }

        $bill->status_bill = 1; // 1 = đã thanh toán
        $bill->save();

        // Đồng bộ luôn order (tuỳ bạn có cần không)
        if ($bill->order) {
            $bill->order->update([
                'payment_status' => 'paid',
                // status_order tuỳ flow của bạn: giữ nguyên hoặc set 1/2...
            ]);
        }

        return back()->with('success', 'Cập nhật trạng thái hóa đơn thành công!');
    }

    public static function markPaidByOrderId(int $orderId, ?string $paymentMethod = null): void
    {
        $order = Order::find($orderId);
        if (!$order) return;

        Bill::updateOrCreate(
            ['id_order' => $order->id_order],
            [
                // nếu bảng bill của bạn có cột code_bill thì set thêm ở đây
                // 'code_bill' => 'BILL' . rand(1000, 9999),
                'payment_method' => $paymentMethod ?? ($order->payment_method ?? 'MOMO'),
                'status_bill'    => 1,
                'total_amount'   => $order->total_amount,
            ]
        );
    }
}
