@extends('admin.layouts.master')
@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="card">
    <div class="card-header bg-light">
        <h5 class="text-danger">Danh sách đơn hàng</h5>
        
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Mã đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id_order }}</td>
                        <td>{{ $order->code_order }}</td>
                        <td>{{ $order->name_customer }}</td>
                        <td>{{ $order->phone_customer }}</td>
                        <td>{{ $order->ward }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                        <td>
                            @switch($order->status_order)
                                @case(0) <span class="badge bg-warning">Chờ xử lý</span> @break
                                @case(1) <span class="badge bg-info">Đã xác nhận</span> @break
                            @endswitch
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.order.show', $order->id_order) }}" class="btn btn-sm btn-outline-info">
                                Xem
                            </a>
                            
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa hóa đơn này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Chưa có hóa đơn nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
