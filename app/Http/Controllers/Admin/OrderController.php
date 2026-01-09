<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Bill;

class OrderController extends Controller
{
    // ✅ ORDER: chỉ hiện đơn chờ xử lý (status = 0)
public function index()
{
    $orders = Order::where('status_order', 0)
        ->where(function ($q) {
            $q->where(function ($q2) {
                // MoMo: chỉ lấy đơn đã thanh toán
                $q2->where('payment_method', 'MOMO')
                   ->where('payment_status', 'paid');
            })
            ->orWhere(function ($q2) {
                // COD: cho xử lý dù chưa thanh toán
                $q2->where('payment_method', 'COD');
            });
        })
        ->orderByDesc('id_order')
        ->get();

    return view('admin.order.index', compact('orders'));
}



    // ➕ FORM THÊM MỚI HÓA ĐƠN
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

    // 💾 LƯU HÓA ĐƠN MỚI
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // (Khuyên) validate tối thiểu để demo ổn định
            $request->validate([
                'name_customer' => 'required|string|max:255',
                'phone_customer' => 'required|string|max:50',
                'province' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'ward' => 'nullable|string|max:255',
                'address_detail' => 'nullable|string|max:255',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required',
                'products.*.quantity' => 'required|integer|min:1',
            ]);

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
                'status_order' => 0, // chờ xử lý
            ]);

            $total = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                if (!$product) continue;

                $qty = (int)$item['quantity'];
                $price = ($product->saleprice_product > 0) ? $product->saleprice_product : $product->price_product;

                $total += $price * $qty;

                OrderDetail::create([
                    'id_order' => $order->id_order,
                    'id_product' => $product->id_product,
                    'quantity' => $qty,
                    'price' => $price,
                ]);
            }

            $order->update(['total_amount' => $total]);

            DB::commit();
            return back()->with('success', 'Tạo hóa đơn thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return back()->with('error', 'Hóa đơn không tồn tại!');
        }

        $orderDetails = OrderDetail::where('id_order', $id)
            ->with('product')
            ->get();

        return view('admin.order.show', compact('order', 'orderDetails'));
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return back()->with('error', 'Hóa đơn không tồn tại!');
        }

        OrderDetail::where('id_order', $id)->delete();
        $order->delete();

        return back()->with('success', 'Xóa hóa đơn thành công!');
    }

    // ✅ NÚT XÁC NHẬN (ORDER chỉ làm việc này): 0 -> 1 và tạo bill nếu cần
    public function confirm($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::lockForUpdate()->findOrFail($id);

            if ((int)$order->status_order !== 0) {
                DB::rollBack();
                return back()->with('error', 'Đơn không ở trạng thái chờ xử lý.');
            }

            // chuyển sang vận chuyển
            $order->update(['status_order' => 1]);

            // tạo bill (nếu bạn cần)
            Bill::firstOrCreate(
                ['id_order' => $order->id_order],
                [
                    'code_bill' => 'BILL' . rand(1000,9999),
                    'payment_method' => 'COD',
                    'status_bill' => 0,
                    'total_amount' => $order->total_amount,
                ]
            );

            DB::commit();

            // ✅ chuyển thẳng sang trang vận chuyển
            return redirect()->route('admin.shipping.index')
                ->with('success', 'Đã xác nhận đơn và chuyển sang vận chuyển.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    // (Tuỳ chọn) nếu bạn vẫn muốn giữ dropdown updateStatus thì giữ,
    // nhưng DEMO theo yêu cầu của bạn thì nên bỏ khỏi UI.
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status_order' => 'required|in:0,1' // Order chỉ cho 0/1
    ]);

    DB::beginTransaction();
    try {
        $order = Order::lockForUpdate()->findOrFail($id);

        $newStatus = (int)$request->status_order;
        $oldStatus = (int)$order->status_order;

        // chỉ cho phép 0 -> 1 hoặc giữ nguyên
        if ($oldStatus === 1 && $newStatus === 0) {
            return back()->with('error', 'Đơn đã xác nhận không được chuyển lại chờ xử lý.');
        }

        $order->status_order = $newStatus;
        $order->save();

        // Nếu xác nhận (1) thì tạo bill nếu chưa có
        if ($newStatus === 1) {
            if (!\App\Models\Bill::where('id_order', $order->id_order)->exists()) {
                \App\Models\Bill::create([
                    'code_bill' => 'BILL' . rand(1000,9999),
                    'id_order' => $order->id_order,
                    'payment_method' => 'COD',
                    'status_bill' => 0,
                    'total_amount' => $order->total_amount,
                ]);
            }

            DB::commit();

            // ✅ XÁC NHẬN xong chuyển sang trang vận chuyển
            return redirect()->route('admin.shipping.index')
                ->with('success', 'Đã xác nhận đơn. Chuyển sang mục Vận chuyển.');
        }

        DB::commit();
        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('error', 'Lỗi: '.$e->getMessage());
    }
}

}
