<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Services\MomoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MomoController extends Controller
{

    public function return(Request $request)
    {
        $orderId    = $request->orderId ?? null;
        $resultCode = $request->resultCode ?? null;

        if ($resultCode == 0) {
            return redirect()->route('home')
                ->with('success', 'Thanh toán MoMo thành công! Mã đơn #' . $orderId . '. Đơn sẽ được xác nhận sớm.');
        }

        return redirect()->route('home')
            ->with('error', 'Thanh toán MoMo thất bại hoặc bị hủy.');
    }
 function ipn(Request $request, MomoService $momo)
    {
        $data = $request->all();
        Log::info('MoMo IPN:', $data);
        if (!$momo->verifySignature($data)) {
            Log::warning('MoMo IPN: Invalid signature', $data);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        if (($data['resultCode'] ?? 999) != 0) {
            Log::info('MoMo IPN: Payment failed', $data);
            return response()->json(['message' => 'Payment failed'], 200);
        }
        $orderId = (int)($data['orderId'] ?? 0);
        $order = Order::with('details')
->where('id_order', $orderId)->first();

        if (!$order) {
            Log::error('MoMo IPN: Order not found', ['orderId' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }
        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Order already paid'], 200);
        }

        DB::beginTransaction();
        try {
            $order->update([
                'payment_status' => 'paid',
                'status_order'   => 0, 
                'payment_code'   => $data['transId'] ?? null,
                'payment_method' => 'MOMO',
            ]);


            Bill::updateOrCreate(
                ['id_order' => $order->id_order],
                [
                    'payment_method' => 'MOMO',
                    'status_bill'    => 1,
                    'total_amount'   => $order->total_amount,
                    'code_bill' => 'BILL' . rand(1000, 9999),
                ]
            );

            // 7) Trừ tồn kho
            foreach ($order->details
 as $detail) {
                $variant = ProductVariant::lockForUpdate()->find($detail->id_product_variant);

                if (!$variant) {
                    throw new \Exception('Biến thể không tồn tại khi trừ kho');
                }

                if ($variant->stock < $detail->quantity) {
                    throw new \Exception('Không đủ tồn kho khi thanh toán MoMo');
                }

                $variant->decrement('stock', $detail->quantity);
            }

            DB::commit();
            return response()->json(['message' => 'Payment success'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('MoMo IPN Error: ' . $e->getMessage(), ['orderId' => $orderId]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * Fake IPN – chỉ để test local
     * Điều kiện: đơn MOMO + unpaid + status_order=9
     */
    public function fakeSuccess($orderId)
    {
        DB::beginTransaction();
        try {
            $order = Order::with('details')
->lockForUpdate()->findOrFail($orderId);

            if (
                strtoupper($order->payment_method) !== 'MOMO' ||
                $order->payment_status !== 'unpaid' ||
                (int)$order->status_order !== 9
            ) {
                return back()->with('error', 'Đơn không hợp lệ để fake thanh toán.');
            }

            // Update Order
            $order->update([
                'payment_status' => 'paid',
                'payment_code'   => 'FAKE_' . time(),
                'status_order'   => 0,
                'payment_method' => 'MOMO',
            ]);

            // Update/Tạo Bill
            Bill::updateOrCreate(
                ['id_order' => $order->id_order],
                [
                    'payment_method' => 'MOMO',
                    'status_bill'    => 1,
                    'total_amount'   => $order->total_amount,
                ]
            );

            // Trừ kho
            foreach ($order->details
 as $detail) {
                $variant = ProductVariant::lockForUpdate()->find($detail->id_product_variant);

                if (!$variant || $variant->stock < $detail->quantity) {
                    throw new \Exception('Không đủ tồn kho');
                }

                $variant->decrement('stock', $detail->quantity);
            }

            // Xóa giỏ hàng (nếu muốn)
            session()->forget('cart');

            DB::commit();

            return redirect()->route('home')
                ->with('success', 'FAKE MoMo thành công! Đơn #' . $order->id_order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi fake IPN: ' . $e->getMessage());
        }
    }
}
