@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">🚚 Vận chuyển</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã đơn</th>
                <th>Khách</th>
                <th>SĐT</th>
                <th>Tổng</th>
                <th>Trạng thái</th>
                <th width="220">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $o)
            <tr>
                <td>{{ $o->code_order }}</td>
                <td>{{ $o->name_customer }}</td>
                <td>{{ $o->phone_customer }}</td>
                <td>{{ number_format($o->total_amount,0,',','.') }} đ</td>
                <td>
                    @if($o->status_order=='1') <span class="badge bg-primary">Đã xác nhận</span> @endif
                    @if($o->status_order=='2') <span class="badge bg-warning text-dark">Đang giao</span> @endif
                    @if($o->status_order=='3') <span class="badge bg-success">Đã giao</span> @endif
                </td>
                <td>
                    @if($o->status_order=='1')
                        <form method="POST" action="{{ route('admin.shipping.pickup',$o->id_order) }}">
                            @csrf
                            <button class="btn btn-sm btn-warning">Bắt đầu giao</button>
                        </form>
                    @elseif($o->status_order=='2')
                        <form method="POST" action="{{ route('admin.shipping.delivered',$o->id_order) }}">
                            @csrf
                            <button class="btn btn-sm btn-success">Đã giao</button>
                        </form>
                    @else
                        <span class="text-muted">Hoàn tất</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
