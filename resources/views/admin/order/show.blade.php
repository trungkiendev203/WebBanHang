@extends('admin.layouts.master')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-danger mb-0">Chi tiết đơn hàng {{ $order->code_order }}</h5>

        {{-- Form cập nhật trạng thái --}}
        <form action="{{ route('admin.order.updateStatus', $order->id_order) }}" method="POST" class="d-flex align-items-center">
            @csrf
            @method('PUT')
            <select name="status_order" class="form-select form-select-sm me-2" style="width: 180px;">
                <option value="0" {{ $order->status_order == 0 ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="1" {{ $order->status_order == 1 ? 'selected' : '' }}>Đã xác nhận</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
        </form>
    </div>

    <div class="card-body">
        <p><strong>Tên khách hàng:</strong> {{ $order->name_customer }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone_customer }}</p>
        <p><strong>Địa chỉ:</strong>
            {{ $order->address_detail }},
            {{ $order->ward }},
            {{ $order->district }},
            {{ $order->province }}
        </p>
        <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>

        <hr>
        <h6>Danh sách sản phẩm</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->details as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $detail->product->name_product }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Tổng cộng:</th>
                    <th>{{ number_format($order->total_amount, 0, ',', '.') }} đ</th>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection
