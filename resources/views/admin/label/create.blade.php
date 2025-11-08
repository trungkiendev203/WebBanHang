@extends('admin.layouts.master')
@section('title', 'Thêm hiệu sản phẩm')

@section('content')
<div class="card">
  <div class="card-header">
    <h5 class="text-danger">Thêm hiệu sản phẩm</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.label.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label>Mã hiệu sản phẩm</label>
        <input type="text" name="code_label" class="form-control" placeholder="Nhập mã hiệu (VD: AoNamHQ)" required>
      </div>

      <div class="mb-3">
        <label>Tên hiệu sản phẩm</label>
        <input type="text" name="name_label" class="form-control" placeholder="Nhập tên hiệu (VD: Áo nam Hàn Quốc)" required>
      </div>

      <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status_label" class="form-select">
          <option value="1">Hiển thị</option>
          <option value="0">Ẩn</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Lưu</button>
      <a href="{{ route('admin.label.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
  </div>
</div>
@endsection
