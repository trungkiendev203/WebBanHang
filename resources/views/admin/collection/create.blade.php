@extends('admin.layouts.master')

@section('title','Thêm bộ sưu tập')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Thêm bộ sưu tập</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.collection.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Tên bộ sưu tập</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Ảnh banner</label>
                <input type="file" name="banner" class="form-control">
            </div>

            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <button class="btn btn-success">Lưu</button>
            <a href="{{ route('admin.collection.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection
