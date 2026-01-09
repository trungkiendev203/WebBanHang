@if($tab === 'orders')
    <h4>Đơn hàng của tôi</h4>

    @if($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @endif

    @foreach($orders as $order)
        <div class="card mb-3">
            <div class="card-body">
                <b>Mã đơn:</b> {{ $order->code_order }} <br>
                <b>Ngày đặt:</b> {{ $order->order_date }} <br>
                <b>Tổng tiền:</b> {{ number_format($order->total_amount) }}đ <br>

                <b>Trạng thái:</b>
                @switch($order->status_order)
                    @case(0) <span class="text-warning">Chờ xác nhận</span> @break
                    @case(1) <span class="text-primary">Đã xác nhận</span> @break
                    @case(2) <span class="text-info">Đang giao</span> @break
                    @case(3) <span class="text-success">Đã giao</span> @break
                    @case(4) <span class="text-danger">Đã hủy</span> @break
                @endswitch

                <br><br>
                <a href="{{ route('client.order.detail', $order->id_order) }}"
                   class="btn btn-sm btn-outline-dark">
                   Xem chi tiết
                </a>
            </div>
        </div>
    @endforeach
@endif
