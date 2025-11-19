@extends('admin.layouts.master')
@section('title', 'Danh sách hóa đơn')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="text-danger">Danh sách hóa đơn</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered text-center">
            <thead>
                <tr class="table-dark">
                    <th>#</th>
                    <th>Mã hóa đơn</th>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Ngày tạo</th>
                    <th>Xem</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $key => $bill)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $bill->code_bill }}</td>
                        <td>{{ $bill->order->code_order ?? '-' }}</td>
                        <td>{{ $bill->order->name_customer ?? '-' }}</td>
                        <td>{{ number_format($bill->total_amount) }}₫</td>
                        <td>
                            @if($bill->status_bill == 0)
                                <span class="badge bg-warning">Chưa thanh toán</span>
                            @else
                                <span class="badge bg-success">Đã thanh toán</span>
                            @endif
                        </td>
                        <td>{{ $bill->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.bill.show', $bill->id_bill) }}" class="btn btn-sm btn-info">Xem</a>
                        <td>
                            @if($bill->status_bill == 0)
                                <form action="{{ route('admin.bill.update', $bill->id_bill) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Đánh dấu đã thanh toán</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
