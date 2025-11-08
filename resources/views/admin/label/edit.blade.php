@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa hiệu sản phẩm')

@section('content')
<div class="card">
    <div class="card-header"><h5>Chỉnh sửa hiệu sản phẩm</h5></div>
    <div class="card-body">
<form action="{{ route('admin.label.update', $label->id_label) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tên hiệu sản phẩm</label>
        <input type="text" name="name_label" class="form-control" value="{{ $label->name_label }}" required>
    </div>

    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status_label" class="form-select">
            <option value="1" {{ $label->status_label == '1' ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ $label->status_label == '0' ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
    <a href="{{ route('admin.label.index') }}" class="btn btn-secondary">Quay lại</a>
</form>

    </div>
</div>
@endsection
