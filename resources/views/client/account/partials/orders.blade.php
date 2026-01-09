<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Đơn hàng của tôi</h3>
        <span class="badge bg-light text-dark">{{ $orders->count() }} đơn hàng</span>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div class="mb-4">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="text-muted">
                    <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                </svg>
            </div>
            <h5 class="text-muted">Chưa có đơn hàng nào</h5>
            <p class="text-muted">Hãy khám phá và mua sắm ngay!</p>
            <a href="/shop" class="btn btn-primary mt-3">Mua sắm ngay</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card card border-0 shadow-sm mb-3 hover-lift">
                <div class="card-body p-0">
                    <!-- Header -->
                    <div class="order-header d-flex justify-content-between align-items-center p-3 border-bottom bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <small class="text-muted d-block">Mã đơn hàng</small>
                                <span class="fw-bold text-primary">{{ $order->code_order }}</span>
                            </div>
                            <div class="vr"></div>
                            <div>
                                <small class="text-muted d-block">Ngày đặt</small>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        
                        @php
                            $statusConfig = [
                                '0' => ['text' => 'Chờ xác nhận', 'class' => 'warning', 'icon' => '⏱️'],
                                '1' => ['text' => 'Đã xác nhận', 'class' => 'info', 'icon' => '✓'],
                                '2' => ['text' => 'Đang giao', 'class' => 'primary', 'icon' => '🚚'],
                                '3' => ['text' => 'Hoàn thành', 'class' => 'success', 'icon' => '✓'],
                                '9' => ['text' => 'Đã hủy', 'class' => 'danger', 'icon' => '✕'],
                            ];
                            $status = $statusConfig[$order->status_order] ?? ['text' => 'Không xác định', 'class' => 'secondary', 'icon' => '?'];
                        @endphp
                        
                        <span class="badge bg-{{ $status['class'] }} px-3 py-2">
                            {{ $status['icon'] }} {{ $status['text'] }}
                        </span>
                    </div>

                    <!-- Product Details -->
                    <div class="order-products p-3">
                        @foreach($order->orderDetails as $detail)
                            <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('uploads/product/' . ($detail->product->image ?? 'default.jpg')) }}" 
                                         alt="{{ $detail->product->name_product ?? 'Product' }}"
                                         class="rounded"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                
                                <!-- Product Info -->
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $detail->product->name_product ?? 'Sản phẩm' }}</h6>
                                    
                                    @if($detail->productVariant)
                                        <div class="d-flex gap-2 mb-2">
                                            @if($detail->productVariant->size)
                                                <span class="badge bg-light text-dark border">Size: {{ $detail->productVariant->size }}</span>
                                            @endif
                                            @if($detail->productVariant->color)
                                                <span class="badge bg-light text-dark border">Màu: {{ $detail->productVariant->color }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">x{{ $detail->quantity }}</span>
                                        <div class="text-end">
                                            <span class="fw-bold text-danger">{{ number_format($detail->price) }}đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer -->
                    <div class="order-footer d-flex justify-content-between align-items-center p-3 border-top bg-light">
                        <div>
                            @php
                                $paymentMethod = $order->payment_method == 'COD' ? '💵 COD' : '💳 ' . $order->payment_method;
                                $paymentStatus = $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán';
                                $paymentClass = $order->payment_status == 'paid' ? 'success' : 'warning';
                            @endphp
                            <small class="text-muted d-block">Phương thức thanh toán</small>
                            <span class="fw-medium">{{ $paymentMethod }}</span>
                            <span class="badge bg-{{ $paymentClass }} ms-2">{{ $paymentStatus }}</span>
                        </div>
                        
                        <div class="text-end">
                            <small class="text-muted d-block">Tổng thanh toán</small>
                            <h5 class="mb-0 text-danger fw-bold">{{ number_format($order->total_amount) }}đ</h5>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="order-actions d-flex gap-2 p-3 border-top">
                        <a href="{{ route('client.order.detail', $order->id_order) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>
                        
                        @if($order->status_order == '3')
                            <button class="btn btn-outline-success btn-sm flex-grow-1" onclick="reorder({{ $order->id_order }})">
                                <i class="bi bi-arrow-repeat"></i> Mua lại
                            </button>
                        @endif
                        
                        @if($order->status_order == '0')
                            <button class="btn btn-outline-danger btn-sm" onclick="cancelOrder({{ $order->id_order }})">
                                <i class="bi bi-x-circle"></i> Hủy
                            </button>
                        @endif
                        
                        @if($order->status_order == '2' && $order->shipping_code)
                            <button class="btn btn-outline-info btn-sm" onclick="trackOrder('{{ $order->shipping_code }}')">
                                <i class="bi bi-truck"></i> Theo dõi
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
    .order-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .order-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .vr {
        width: 1px;
        height: 30px;
        background-color: #dee2e6;
    }
    
    .order-products img {
        border: 1px solid #e9ecef;
    }
    
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-danger:hover,
    .btn-outline-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>

<script>
function cancelOrder(orderId) {
    if(confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
        // Call API to cancel order
        fetch(`/order/cancel/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    }
}

function reorder(orderId) {
    // Add items from this order back to cart
    window.location.href = `/order/reorder/${orderId}`;
}

function trackOrder(shippingCode) {
    // Open tracking page
    window.open(`/order/track/${shippingCode}`, '_blank');
}
</script>