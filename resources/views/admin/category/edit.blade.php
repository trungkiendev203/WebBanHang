@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa loại sản phẩm')

@section('content')
<div class="card">
    <div class="card-header"><h5>Chỉnh sửa loại sản phẩm</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.category.update', $category->id_category) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Tên loại sản phẩm</label>
                <input type="text" name="name_category" class="form-control" value="{{ $category->name_category }}" required>
            </div>
            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status_category" class="form-select">
                    <option value="1" {{ $category->status_category == '1' ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $category->status_category == '0' ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection
