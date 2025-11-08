@extends('admin.layouts.master')
@section('title', 'Hiệu sản phẩm')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-danger mb-0">Hiệu sản phẩm</h5>
        <a href="{{ route('admin.label.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm
        </a>
    </div>

    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="Tìm kiếm hiệu sản phẩm...">
                <button class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
            </div>
        </form>

        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Mã hiệu sản phẩm</th>
                    <th>Tên hiệu sản phẩm</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labels as $index => $label)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $label->code_label }}</td>
                        <td>{{ $label->name_label }}</td>
                        <td>
                            @if($label->status_label == '1')
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.label.edit', $label->id_label) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.label.destroy', $label->id_label) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa hiệu này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Chưa có hiệu sản phẩm nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
