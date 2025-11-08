<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LabelController extends Controller
{
    // Danh sách hiệu sản phẩm
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $labels = Label::when($keyword, function($query, $keyword) {
                $query->where('name_label', 'like', "%$keyword%")
                      ->orWhere('code_label', 'like', "%$keyword%");
            })
            ->orderBy('id_label', 'desc')
            ->get();

        return view('admin.label.index', compact('labels', 'keyword'));
    }

    // Form thêm mới
    public function create()
    {
        return view('admin.label.create');
    }

    // Xử lý thêm mới
public function store(Request $request)
{
    $request->validate([
        'code_label' => 'required|unique:tb_label,code_label|max:50',
        'name_label' => 'required|max:255',
    ]);

    Label::create([
        'code_label' => $request->code_label,
        'name_label' => $request->name_label,
        'slug_label' => Str::slug($request->name_label),

        'status_label' => $request->status_label ?? '1',
    ]);

    return redirect()->route('admin.label.index')->with('success', 'Thêm hiệu sản phẩm thành công!');
}


    // Cập nhật hiệu sản phẩm
public function update(Request $request, $id)
{
    // B1: Validate dữ liệu gửi lên
    $request->validate([
        'name_label' => 'required|max:255',
        'status_label' => 'nullable|in:0,1',
    ]);

    // B2: Lấy record cần cập nhật
    $label = \App\Models\Label::findOrFail($id);

    // B3: Cập nhật dữ liệu
    $label->update([
        'name_label' => $request->name_label,
        'slug_label' => Str::slug($request->name_label),
        'status_label' => $request->status_label ?? '1',
        'updated_at' => now(),
    ]);

    // B4: Quay lại danh sách + thông báo
    return redirect()->route('admin.label.index')->with('success', 'Cập nhật hiệu sản phẩm thành công!');
}

// Form chỉnh sửa
public function edit($id)
{
    $label = Label::findOrFail($id);
    return view('admin.label.edit', compact('label'));
}

    // Xóa hiệu sản phẩm
    public function destroy($id)
    {
        Label::destroy($id);
        return redirect()->route('admin.label.index')->with('success', 'Đã xóa hiệu sản phẩm!');
    }
}
