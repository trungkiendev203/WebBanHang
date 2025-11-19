@extends('admin.layouts.master')
@section('title', 'Chi tiết hóa đơn')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="text-danger mb-0">Chi tiết hóa đơn {{ $bill->code_bill }}</h5>

        {{-- Form cập nhật trạng thái thanh toán --}}
        @if($bill->status_bill == 0)
        <form action="{{ route('admin.bill.update', $bill->id_bill) }}" method="POST" class="d-flex align-items-center">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-primary btn-sm">Đánh dấu đã thanh toán</button>
        </form>
        @endif
    </div>

    <div class="card-body">
        <p><strong>Mã đơn hàng:</strong> {{ $bill->order->code_order ?? '-' }}</p>
        <p><strong>Tên khách hàng:</strong> {{ $bill->order->name_customer ?? '-' }}</p>
        <p><strong>Số điện thoại:</strong> {{ $bill->order->phone_customer ?? '-' }}</p>
        <p><strong>Địa chỉ:</strong>
            {{ $bill->order->address_detail ?? '-' }},
            {{ $bill->order->ward ?? '-' }},
            {{ $bill->order->district ?? '-' }},
            {{ $bill->order->province ?? '-' }}
        </p>
        <p><strong>Ngày tạo hóa đơn:</strong> {{ $bill->created_at->format('d/m/Y H:i') }}</p>

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
                @foreach($bill->order->details as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $detail->product->name_product }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection