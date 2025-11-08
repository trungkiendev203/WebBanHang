<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1️⃣ Thống kê cơ bản ---
        $totalProducts = Product::count(); // Tổng sản phẩm
        $totalViews = Product::sum('view_product'); // Tổng lượt xem

        // --- 2️⃣ Lấy đơn hàng từ bảng tb_order ---
        $orderStats = DB::table('tb_order')
            ->selectRaw('SUM(quantity_product) AS total_sold, SUM(quantity_product * saleprice_product) AS total_revenue')
            ->first();

        $totalSold = $orderStats->total_sold ?? 0;
        $totalRevenue = $orderStats->total_revenue ?? 0;

        // --- 3️⃣ Doanh thu theo tháng (chỉ lấy tháng có đơn hàng thật) ---
// Doanh thu đầy đủ 12 tháng (tháng nào không có = 0)
$rawRevenue = DB::table('tb_order')
    ->selectRaw('MONTH(created_at) as thang, SUM(quantity_product * saleprice_product) as total')
    ->groupBy('thang')
    ->pluck('total', 'thang'); // trả về dạng [11 => 997000, 12 => ...]

$monthlyRevenue = collect([]);
for ($i = 1; $i <= 12; $i++) {
    $monthlyRevenue->push([
        'thang' => 'Th' . $i,
        'total' => $rawRevenue[$i] ?? 0, // nếu không có tháng đó thì = 0
    ]);
}



        // --- 4️⃣ Lấy top sản phẩm bán chạy ---
        $products = DB::table('tb_product')
            ->leftJoin('tb_order', 'tb_product.id_product', '=', 'tb_order.id_product')
            ->select(
                'tb_product.id_product',
                'tb_product.code_product',
                'tb_product.name_product',
                'tb_product.image',
                'tb_product.price_product',
                'tb_product.saleprice_product',
                'tb_product.view_product',
                'tb_product.status_product',
                'tb_product.quantity',
                DB::raw('SUM(tb_order.quantity_product) as quantity_sold')
            )
            ->groupBy(
                'tb_product.id_product',
                'tb_product.code_product',
                'tb_product.name_product',
                'tb_product.image',
                'tb_product.price_product',
                'tb_product.saleprice_product',
                'tb_product.view_product',
                'tb_product.status_product',
                'tb_product.quantity'
            )
            ->orderByDesc('quantity_sold')
            ->limit(8)
            ->get();

        // --- 5️⃣ Truyền dữ liệu sang view ---
        return view('admin.dashboard', compact(
            'products',
            'totalProducts',
            'totalViews',
            'totalSold',
            'totalRevenue',
            'monthlyRevenue' // 💡 thêm dòng này
        ));
    }
}
