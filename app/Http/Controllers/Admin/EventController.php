<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    // 📌 Danh sách sự kiện
    public function index()
    {
        $events = DB::table('tb_event')
            ->orderByDesc('id_event')
            ->get();

        return view('admin.event.index', compact('events'));
    }

    // 📌 Form tạo
public function create()
{
    $products = DB::table('tb_product')
        ->where('status_product', 1)
        ->orderByDesc('id_product')
        ->get();

    return view('admin.event.create', compact('products'));
}


    // 📌 Lưu sự kiện
public function store(Request $request)
{
    $request->validate([
        'title'      => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date'
    ]);

    $eventId = DB::table('tb_event')->insertGetId([
        'title'        => $request->title,
        'subtitle'     => $request->subtitle,
        'badge_text'   => $request->badge_text,
        'badge_color'  => $request->badge_color ?? '#ff0000',
        'start_date'   => $request->start_date,
        'end_date'     => $request->end_date,
        'position'     => $request->position,
        'status'       => $request->status ?? 0,
        'created_at'   => now(),
        'updated_at'   => now()
    ]);

    // 👉 LƯU SẢN PHẨM CHO EVENT
    if ($request->products) {
        foreach ($request->products as $productId) {
            DB::table('tb_event_product')->insert([
                'id_event'   => $eventId,
                'id_product' => $productId
            ]);
        }
    }

    return redirect()->route('admin.event.index')
        ->with('success', 'Tạo sự kiện thành công');
}


    // 📌 Form sửa
public function edit($id)
{
    $event = DB::table('tb_event')->where('id_event', $id)->first();

    $products = DB::table('tb_product')
        ->where('status_product', 1)
        ->get();

    $selectedProducts = DB::table('tb_event_product')
        ->where('id_event', $id)
        ->pluck('id_product')
        ->toArray();

    return view('admin.event.edit', compact(
        'event',
        'products',
        'selectedProducts'
    ));
}

public function update(Request $request, $id)
{
    DB::table('tb_event')->where('id_event', $id)->update([
        'title'        => $request->title,
        'subtitle'     => $request->subtitle,
        'badge_text'   => $request->badge_text,
        'badge_color'  => $request->badge_color,
        'start_date'   => $request->start_date,
        'end_date'     => $request->end_date,
        'position'     => $request->position,
        'status'       => $request->status ?? 0,
        'updated_at'   => now()
    ]);

    // 👉 RESET SẢN PHẨM CŨ
    DB::table('tb_event_product')
        ->where('id_event', $id)
        ->delete();

    // 👉 LƯU SẢN PHẨM MỚI
    if ($request->products) {
        foreach ($request->products as $productId) {
            DB::table('tb_event_product')->insert([
                'id_event'   => $id,
                'id_product' => $productId
            ]);
        }
    }

    return redirect()->route('admin.event.index')
        ->with('success', 'Cập nhật thành công');
}


    // 📌 Bật / tắt nhanh
    public function toggle($id)
    {
        $event = DB::table('tb_event')->where('id_event', $id)->first();

        DB::table('tb_event')->where('id_event', $id)->update([
            'status' => $event->status ? 0 : 1
        ]);

        return back();
    }
}
