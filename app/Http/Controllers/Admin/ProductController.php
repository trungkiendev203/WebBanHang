<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Label;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ================================
    // 📌 LIST + SEARCH + PAGINATE
    // ================================
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::with(['category', 'label', 'variants'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('name_product', 'like', "%$keyword%")
                      ->orWhere('code_product', 'like', "%$keyword%");
            })
            ->orderBy('id_product', 'desc')
            ->paginate(15);

        return view('admin.product.index', compact('products', 'keyword'));
    }

    // ================================
    // 📌 SHOW CREATE FORM
    // ================================
    public function create()
    {
        $categories = Category::all();
        $labels = Label::all();
        return view('admin.product.create', compact('categories', 'labels'));
    }

    // ================================
    // 📌 STORE PRODUCT
    // ================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_product'      => 'required|string|max:255',
            'price_product'     => 'required|integer|min:0',
            'saleprice_product' => 'nullable|integer|min:0',
            'import_price'      => 'nullable|integer|min:0',
            'describe_product'  => 'nullable|string',
            'status_product'    => 'nullable|string|max:1',
            'id_category'       => 'nullable|integer',
            'id_label'          => 'nullable|integer',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10048',
        ]);

        // 🔹 Create slug
        $slug = Str::slug($request->name_product) . '-' . time();

        // 🔹 Create product code
        $code = 'SP-' . strtoupper(substr(md5(uniqid()), 0, 6));


        // 🔹 Create product
        $product = Product::create([
            'code_product'      => $code,
            'name_product'      => $request->name_product,
            'slug_product'      => $slug,
            'price_product'     => $request->price_product,
            'saleprice_product' => $request->saleprice_product ?? 0,
            'import_price'      => $request->import_price ?? 0,
            'describe_product'  => $request->describe_product,
            'view_product'      => 0,
            'status_product'    => $request->status_product ?? '1',
            'id_category'       => $request->id_category,
            'id_label'          => $request->id_label,
        ]);

        if ($request->variants) {
            foreach ($request->variants as $variant) {
                ProductVariant::create([
                    'id_product' => $product->id_product,
                    'sku'        => 'SKU-' . strtoupper(Str::random(6)), // AUTO SKU
                    'size'       => $variant['size'],
                    'color'      => $variant['color'],
                    'stock'      => $variant['stock'],
                ]);
            }
        }

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

                if ($index === 0) {
                    $firstImage = $name;
                }
            }

            if ($firstImage) {
                $product->update(['image' => $firstImage]);
            }
        }

        return redirect()->route('admin.product.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);
        $categories = Category::all();
        $labels = Label::all();
        return view('admin.product.edit', compact('product', 'categories', 'labels'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name_product'      => 'required|string|max:255',
            'price_product'     => 'required|integer|min:0',
            'saleprice_product' => 'nullable|integer|min:0',
            'import_price'      => 'nullable|integer|min:0',
            'describe_product'  => 'nullable|string',
            'status_product'    => 'nullable|string|max:1',
            'id_category'       => 'nullable|integer',
            'id_label'          => 'nullable|integer',
        ]);

        $product->update($validated);
        ProductVariant::where('id_product', $product->id_product)->delete();

        if ($request->variants) {
            foreach ($request->variants as $variant) {
                ProductVariant::create([
                    'id_product' => $product->id_product,
                    'sku'        => 'SKU-' . strtoupper(Str::random(6)), // AUTO SKU
                    'size'       => $variant['size'],
                    'color'      => $variant['color'],

                    'stock'      => $variant['stock'],
                ]);
            }
        }
        if ($request->filled('deleted_images')) {
            $ids = explode(',', $request->deleted_images);
            $images = ProductImage::whereIn('id_image', $ids)->get();

            foreach ($images as $img) {
                $path = public_path('uploads/product/' . $img->image_url);
                if (file_exists($path)) unlink($path);
                $img->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/product'), $name);

                ProductImage::create([
                    'id_product' => $product->id_product,
                    'image_url'  => $name,
                    'created_at' => now(),
                ]);
            }
        }

        // ================================
        // 📌 UPDATE MAIN IMAGE
        // ================================
        $mainImage = ProductImage::where('id_product', $product->id_product)
                                 ->latest('id_image')->first();

        if ($mainImage) {
            $product->update(['image' => $mainImage->image_url]);
        }

        return redirect()->route('admin.product.edit', $product->id_product)
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // ================================
    // 📌 DELETE PRODUCT
    // ================================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->variants()->delete();

        foreach ($product->images as $img) {
            $path = public_path('uploads/product/' . $img->image_url);
            if (file_exists($path)) unlink($path);
        }

        $product->images()->delete();
        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

public function detail($slug)
{
    $product = Product::where('slug_product', $slug)->firstOrFail();

    // Lấy size + số lượng
    $sizes = $product->variants
        ->groupBy('size')
        ->map(function ($items) {
            return $items->sum('quantity');
        });

    return view('client.product.detail', compact('product', 'sizes'));
}

}
