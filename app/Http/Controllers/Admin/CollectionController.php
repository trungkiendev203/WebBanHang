<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::latest()->paginate(10);
        return view('admin.collection.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collection.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:collections,name',
            'banner' => 'nullable|image'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 1
        ];

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/collections'), $filename);
            $data['banner'] = $filename;
        }

        Collection::create($data);

        return redirect()->route('admin.collection.index')
            ->with('success', 'Thêm bộ sưu tập thành công');
    }
}

