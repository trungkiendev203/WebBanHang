<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id_category', 'desc')->get();
        return view('admin.category.index', compact('categories'));
    }
public function create()
{
    $allCategories = Category::orderBy('name_category')->get();
    $categories = $this->buildCategoryTree($allCategories);

    return view('admin.category.create', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'code_category' => 'nullable|string|max:10',
        'name_category' => 'required|string|max:255',
    ]);

    Category::create([

        'code_category' => $request->code_category ?: 'CAT-' . strtoupper(Str::random(5)),
        'name_category' => $request->name_category,
        'slug_category' => Str::slug($request->name_category),
        'status_category' => $request->status_category ?? '1',
        'parent_id' => $request->parent_id ?? null,
    ]);

    return redirect()->route('admin.category.index')->with('success', 'Thêm loại sản phẩm thành công!');
}
private function buildCategoryTree($categories, $parentId = null, $prefix = '')
{
    $result = [];

    foreach ($categories as $category) {
        if ($category->parent_id == $parentId) {
            $category->display_name = $prefix . $category->name_category;
            $result[] = $category;
            $children = $this->buildCategoryTree($categories, $category->id_category, $prefix . '- ');
            $result = array_merge($result, $children);
        }
    }

    return $result;
}


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name_category' => $request->name_category,
            'slug_category' => Str::slug($request->name_category),
            'status_category' => $request->status_category ?? '1',
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('admin.category.index')->with('success', 'Xoá thành công!');
    }
}
