<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // Danh sách hóa đơn
    public function index()
    {
        $bills = Bill::with('order')->orderBy('id_bill', 'desc')->get();
        return view('admin.bill.index', compact('bills'));
    }

    // Cập nhật trạng thái thanh toán
    public function update($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->status_bill = 1; // 1 = đã thanh toán
        $bill->save();

        return back()->with('success', 'Cập nhật trạng thái hóa đơn thành công!');
    }
    public function show($id)
{
    $bill = Bill::with(['order.orderDetails.product'])->findOrFail($id);
    return view('admin.bill.show', compact('bill'));
}


}
