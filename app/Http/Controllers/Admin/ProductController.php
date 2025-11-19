<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Label;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::with(['category', 'label'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('name_product', 'like', "%$keyword%")
                      ->orWhere('code_product', 'like', "%$keyword%");
            })
            ->orderBy('id_product', 'desc')
            ->get();

        return view('admin.product.index', compact('products', 'keyword'));
    }

    // Form thêm mới
    public function create()
    {
        $categories = Category::all();
        $labels = Label::all();
        return view('admin.product.create', compact('categories', 'labels'));
    }

public function store(Request $request)
{
    // ================================
    // 🔹 1. VALIDATE DỮ LIỆU
    // ================================
    $validated = $request->validate([
        'name_product' => 'required|string|max:255',
        'price_product' => 'required|integer|min:0',
        'saleprice_product' => 'nullable|integer|min:0',
        'import_price' => 'nullable|integer|min:0',
        'describe_product' => 'nullable|string',
        'size_product' => 'nullable|string',
        'quantity' => 'nullable|integer|min:0',
        'status_product' => 'nullable|string|max:1',
        'id_category' => 'nullable|integer',
        'id_label' => 'nullable|integer',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10048',
    ]);

    // ================================
    // 🔹 2. SINH CODE SẢN PHẨM TỰ ĐỘNG
    // ================================
    $code = $request->input('code_product') ?: 'SP' . rand(1000, 9999);

    // ================================
    // 🔹 3. TẠO SLUG SẢN PHẨM
    // ================================
    $slug = Str::slug($request->name_product) . '-' . time();

    // ================================
    // 🔹 4. LƯU SẢN PHẨM VÀO DATABASE
    // ================================
    $product = Product::create([
        'code_product'      => $code,
        'name_product'      => $request->name_product,
        'slug_product'      => $slug,
        'price_product'     => $request->price_product,
        'saleprice_product' => $request->saleprice_product ?? 0,
        'import_price'      => $request->import_price ?? 0,
        'describe_product'  => $request->describe_product,
        'size_product'      => $request->size_product,
        'quantity'          => $request->quantity ?? 0,
        'view_product'      => 0,
        'status_product'    => $request->status_product ?? '1',
        'id_category'       => $request->id_category,
        'id_label'          => $request->id_label,
    ]);

    // ================================
    // 🔹 5. UPLOAD ẢNH (NHIỀU ẢNH)
    // ================================
    if ($request->hasFile('images')) {
        $firstImage = null;

        foreach ($request->file('images') as $index => $file) {
            $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/product'), $name);

            ProductImage::create([
                'id_product' => $product->id_product,
                'image_url'  => $name,
                'created_at' => now(),
            ]);

            // Lấy ảnh đầu tiên làm ảnh chính
            if ($index === 0) {
                $firstImage = $name;
            }
        }

        // Cập nhật ảnh chính vào bảng sản phẩm
        if ($firstImage) {
            $product->update(['image' => $firstImage]);
        }
    }

    // ================================
    // 🔹 6. TRẢ VỀ
    // ================================
    return redirect()->route('admin.product.index')
        ->with('success', 'Thêm sản phẩm thành công!');
}


    // Form chỉnh sửa
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        $labels = Label::all();
        return view('admin.product.edit', compact('product', 'categories', 'labels'));
    }

    // Cập nhật sản phẩm
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validate dữ liệu cơ bản
    $validated = $request->validate([
        'name_product' => 'required|string|max:255',
        'price_product' => 'required|integer|min:0',
        'saleprice_product' => 'nullable|integer|min:0',
        'import_price' => 'nullable|integer|min:0',
        'describe_product' => 'nullable|string',
        'status_product' => 'nullable|string|max:1',
        'id_category' => 'nullable|integer',
        'id_label' => 'nullable|integer',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10048',
    ]);

    // Cập nhật thông tin chính
    $product->update($validated);

    // =============================
    // 🔹 XỬ LÝ SIZE + SỐ LƯỢNG
    // =============================
    $sizes = $request->input('sizes', []);
    $quantities = $request->input('quantities', []);
    $sizeData = [];

    foreach ($sizes as $size) {
        $qty = $quantities[$size] ?? 0;
        $sizeData[] = "$size:$qty";
    }

    $product->update([
        'size_product' => implode(',', $sizeData),
        'quantity' => array_sum($quantities),
    ]);

    // =============================
    // 🔹 XÓA ẢNH ĐƯỢC CHỌN XÓA
    // =============================
    if ($request->filled('deleted_images')) {
        $ids = explode(',', $request->deleted_images);
        $images = ProductImage::whereIn('id_image', $ids)->get();

        foreach ($images as $img) {
            $path = public_path('uploads/product/' . $img->image_url);
            if (file_exists($path)) unlink($path);
            $img->delete();
        }
    }

    // =============================
    // 🔹 UPLOAD ẢNH MỚI
    // =============================
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/product'), $name);

            ProductImage::create([
                'id_product' => $product->id_product,
                'image_url' => $name,
                'created_at' => now(),
            ]);
        }
    }

    // =============================
    // 🔹 ẢNH TỪ LINK NGOÀI
    // =============================
    if ($request->filled('image_links')) {
        foreach ($request->image_links as $url) {
            ProductImage::create([
                'id_product' => $product->id_product,
                'image_url' => $url,
                'created_at' => now(),
            ]);
        }
    }

    // =============================
    // 🔹 CẬP NHẬT LẠI ẢNH CHÍNH
    // =============================
    $firstImage = ProductImage::where('id_product', $product->id_product)->latest('id_image')->first();
    if ($firstImage) {
        $product->update(['image' => $firstImage->image_url]);
    }

    return redirect()->route('admin.product.edit', $product->id_product)
                     ->with('success', 'Cập nhật sản phẩm thành công!');
}


    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Xóa ảnh phụ
        foreach ($product->images as $img) {
            $path = public_path('uploads/product/' . $img->image_url);
            if (file_exists($path)) unlink($path);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    // Xóa ảnh phụ riêng lẻ
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $path = public_path('uploads/product/' . $image->image_url);

        if (file_exists($path)) unlink($path);
        $image->delete();

        return back()->with('success', 'Đã xóa ảnh thành công!');
    }
}
