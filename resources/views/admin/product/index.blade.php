@extends('admin.layouts.master')
@section('title', 'Tất cả sản phẩm')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-danger">Tất cả Sản Phẩm</h5>
        <a href="{{ route('admin.product.create') }}" class="btn btn-success">Thêm +</a>
    </div>

    <div class="card-body">
        <form class="mb-3" method="GET" action="{{ route('admin.product.index') }}">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="keyword" value="{{ $keyword }}" class="form-control" placeholder="Tìm kiếm...">
                <button class="btn btn-primary">Tìm</button>
            </div>
        </form>

        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr class="text-center">
                    <th>Mã sp</th>
                    <th>Tên sp</th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Loại sp</th>
                    <th>Hiệu sp</th>
                    <th>Hình ảnh</th>
                    <th>Giá nhập</th>
                    <th>Giá gốc</th>
                    <th>Giá bán</th>
                    <th>Mô tả</th>
                   
                    <th>Ngày thêm</th>
                    <th>Trạng thái</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    <td>{{ $item->code_product }}</td>
                    <td>{{ $item->name_product }}</td>
                    <td>{{ $item->size_product }}</td>
                    <td>{{ $item->quantity_product }}</td>
                    <td>{{ $item->category->name_category ?? '—' }}</td>
                    <td>{{ $item->label->name_label ?? '—' }}</td>
<td>
@if(Str::startsWith($item->image, ['http://', 'https://']))
    <img src="{{ $item->image }}" width="70" class="rounded border">
@else
    <img src="{{ asset('uploads/product/' . $item->image) }}" width="70" class="rounded border">
@endif

</td>


                    <td>{{ number_format($item->import_price) }} VND</td>
                    <td>{{ number_format($item->price_product) }} VND</td>
                    <td>{{ number_format($item->saleprice_product) }} VND</td>
                    <td>{{ Str::limit($item->describe_product, 60) }}</td>
                    
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->status_product == '1' ? 'Còn hàng' : 'Hết hàng' }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.product.edit', $item->id_product) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('admin.product.destroy', $item->id_product) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa sản phẩm này?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
