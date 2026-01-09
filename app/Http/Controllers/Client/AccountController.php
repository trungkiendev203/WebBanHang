<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Order;

class AccountController extends Controller
{
public function index(Request $request)
{
    $customer = Auth::guard('customer')->user();
    $tab = $request->get('tab', 'profile');

    $addresses = CustomerAddress::where('id_customer', $customer->id_customer)
        ->orderByDesc('is_default')
        ->get();

    // tổng đơn (sidebar)
    $orderCount = Order::where('id_customer', $customer->id_customer)->count();

    $orders = collect();

    if ($tab === 'orders') {
        $orders = Order::with([
                'orderDetails.product',
                'orderDetails.productVariant'
            ])
            ->where('id_customer', $customer->id_customer) // nếu DB bạn có cột này
            ->orderByDesc('order_date')
            ->paginate(10)
            ->withQueryString(); // giữ ?tab=orders khi phân trang
    }

    return view('client.account.index', compact(
        'customer','tab','addresses','orders','orderCount'
    ));
}


    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:tb_customer,phone,' 
                        . $customer->id_customer . ',id_customer',
        ]);

        $customer->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công');
    }
}
