@extends('admin.layouts.master')

@section('content')
<h3>Thêm sự kiện</h3>

<form method="POST" action="{{ route('admin.event.store') }}">
@csrf

<div class="mb-3">
    <label>Tiêu đề</label>
    <input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
    <label>Badge</label>
    <input type="text" name="badge_text" class="form-control" placeholder="SALE / HOT">
</div>

<div class="mb-3">
    <label>Màu badge</label>
    <input type="color" name="badge_color" value="#ff0000">
</div>

<div class="mb-3">
    <label>Thời gian</label>
    <input type="datetime-local" name="start_date">
    <input type="datetime-local" name="end_date">
</div>

<div class="mb-3">
    <label>Vị trí</label>
    <select name="position" class="form-control">
        <option value="header">Header</option>
        <option value="banner">Banner</option>
        <option value="popup">Popup</option>
    </select>
</div>

<div class="mb-3">
    <label>
        <input type="checkbox" name="status" value="1"> Bật ngay
    </label>
</div>

<button class="btn btn-success">Lưu</button>
</form>
@endsection
