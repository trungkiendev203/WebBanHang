@extends('client.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
@php
    // Map trạng thái theo DB của bạn: 0/1/2/3/9
    $statusConfig = [
        '0' => ['text' => 'Chờ xác nhận', 'class' => 'warning', 'desc' => 'Đơn hàng đang chờ shop xác nhận.', 'icon' => 'clock-history'],
        '1' => ['text' => 'Đã xác nhận', 'class' => 'info', 'desc' => 'Shop đã xác nhận và chuẩn bị hàng.', 'icon' => 'check-circle'],
        '2' => ['text' => 'Đang giao', 'class' => 'primary', 'desc' => 'Đơn hàng đang được vận chuyển.', 'icon' => 'truck'],
        '3' => ['text' => 'Hoàn thành', 'class' => 'success', 'desc' => 'Giao hàng thành công. Cảm ơn bạn!', 'icon' => 'check-circle-fill'],
        '9' => ['text' => 'Đã hủy', 'class' => 'danger', 'desc' => 'Đơn hàng đã bị hủy.', 'icon' => 'x-circle'],
    ];
    $status = $statusConfig[(string)($order->status_order ?? '0')] ?? ['text'=>'Không xác định','class'=>'secondary','desc'=>'','icon'=>'question-circle'];

    // Tính tổng
    $subtotal = 0;
    foreach ($order->orderDetails ?? [] as $d) {
        $subtotal += ((int)$d->quantity) * ((int)$d->price);
    }
    $shippingFee = 0;
    $discount    = 0;
    $grandTotal  = (int)($order->total_amount ?? 0) > 0 ? (int)$order->total_amount : ($subtotal + $shippingFee - $discount);

    $paymentMethod = ($order->payment_method ?? 'COD') === 'COD'
        ? '💵 Thanh toán khi nhận hàng (COD)'
        : '💳 ' . ($order->payment_method ?? '');

    $paymentStatus = ($order->payment_status ?? 'unpaid') === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán';
    $paymentClass  = ($order->payment_status ?? 'unpaid') === 'paid' ? 'success' : 'warning';

    // Progress steps
    $stepIndex = 1;
    if ((string)$order->status_order === '1') $stepIndex = 2;
    if ((string)$order->status_order === '2') $stepIndex = 3;
    if ((string)$order->status_order === '3') $stepIndex = 4;
@endphp

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .shopee-wrap { 
        background: linear-gradient(135deg, #f5f5f5 0%, #e9ecef 100%);
        padding: 32px 0; 
        min-height: 100vh;
    }

    .sh-card { 
        background: #fff; 
        border: none;
        border-radius: 16px; 
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.5s ease-out;
    }

    .sh-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .sh-card + .sh-card { 
        margin-top: 16px; 
    }

    .sh-hd { 
        padding: 20px 24px; 
        background: linear-gradient(135deg, #fafafa 0%, #f0f2f5 100%);
        border-bottom: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .sh-hd::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 2s infinite;
    }

    .sh-bd { 
        padding: 24px; 
    }

    .muted { 
        color: #6c757d; 
    }

    .mono { 
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; 
    }

    .progress-steps { 
        display: flex; 
        gap: 12px; 
        align-items: center; 
        flex-wrap: wrap; 
        position: relative;
    }

    .step { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        flex: 1; 
        min-width: 170px;
        animation: slideInRight 0.5s ease-out;
        animation-fill-mode: both;
    }

    .step:nth-child(1) { animation-delay: 0.1s; }
    .step:nth-child(2) { animation-delay: 0.2s; }
    .step:nth-child(3) { animation-delay: 0.3s; }
    .step:nth-child(4) { animation-delay: 0.4s; }

    .dot { 
        width: 48px; 
        height: 48px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border: 3px solid #dee2e6; 
        background: #fff; 
        font-weight: 700;
        font-size: 18px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 2;
    }

    .dot::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .line { 
        height: 3px; 
        background: linear-gradient(90deg, #dee2e6 0%, #e9ecef 100%);
        flex: 1;
        position: relative;
        overflow: hidden;
    }

    .line::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, #198754, #20c997);
        transition: width 0.6s ease;
    }

    .step.done .dot { 
        border-color: #198754; 
        background: linear-gradient(135deg, #198754, #20c997);
        color: #fff;
        animation: pulse 2s infinite;
    }

    .step.done .dot::after {
        border-color: #198754;
        transform: scale(1.3);
        opacity: 0;
        animation: ripple 1.5s ease-out infinite;
    }

    .step.done .line::before { 
        width: 100%;
    }

    .step.active .dot { 
        border-color: #0d6efd; 
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        color: #fff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        animation: pulse 1.5s infinite;
    }

    .step.cancel .dot { 
        border-color: #dc3545; 
        color: #dc3545; 
    }

    @keyframes ripple {
        0% {
            transform: scale(1);
            opacity: 0.5;
        }
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    .prod-row { 
        display: flex; 
        gap: 16px; 
        padding: 16px 0; 
        border-bottom: 1px dashed #e9ecef;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease-out;
    }

    .prod-row:hover {
        background: #f8f9fa;
        margin: 0 -24px;
        padding: 16px 24px;
        border-radius: 12px;
    }

    .prod-row:last-child { 
        border-bottom: 0; 
    }

    .prod-img { 
        width: 90px; 
        height: 90px; 
        border-radius: 12px; 
        object-fit: cover; 
        border: 2px solid #e9ecef; 
        background: #fafafa;
        transition: all 0.3s ease;
    }

    .prod-row:hover .prod-img {
        transform: scale(1.05);
        border-color: #0d6efd;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .chip { 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        padding: 4px 12px; 
        border-radius: 999px; 
        border: 1px solid #e9ecef; 
        background: linear-gradient(135deg, #fafafa 0%, #f8f9fa 100%);
        font-size: 12px; 
        color: #495057; 
        margin-right: 6px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .chip:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .total-box { 
        display: flex; 
        justify-content: space-between; 
        padding: 12px 0;
        transition: all 0.3s ease;
    }

    .total-box:hover {
        background: #f8f9fa;
        margin: 0 -12px;
        padding: 12px;
        border-radius: 8px;
    }

    .total-box .lbl { 
        color: #6c757d;
        font-weight: 500;
    }

    .big-total { 
        font-size: 28px; 
        font-weight: 800; 
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: pulse 2s infinite;
    }

    .btn-soft { 
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-soft:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn {
        transition: all 0.3s ease;
        font-weight: 500;
        border-radius: 8px;
        padding: 8px 20px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn:active {
        transform: translateY(0);
    }

    .badge {
        padding: 6px 14px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease-out;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #fff;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        color: #495057;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: linear-gradient(135deg, #e7f3ff 0%, #cfe2ff 100%);
        color: #0d6efd;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        animation: fadeInUp 0.5s ease-out;
    }

    .copy-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .copy-btn:hover {
        background: linear-gradient(135deg, #0b5ed7, #0aa2c0);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        animation: fadeInUp 0.5s ease-out;
    }

    .icon-animated {
        display: inline-block;
        animation: pulse 2s infinite;
    }

    @media (max-width: 768px) {
        .shopee-wrap { padding: 16px 0; }
        .sh-hd, .sh-bd { padding: 16px; }
        .dot { width: 40px; height: 40px; font-size: 16px; }
        .prod-img { width: 70px; height: 70px; }
        .big-total { font-size: 24px; }
    }
</style>

<div class="shopee-wrap">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('client.account', ['tab' => 'orders']) }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                    <span>Quay lại</span>
                </a>
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-receipt icon-animated"></i>
                    Chi tiết đơn hàng
                </h4>
            </div>

            <span class="badge bg-{{ $status['class'] }}">
                <i class="bi bi-{{ $status['icon'] }}"></i>
                {{ $status['text'] }}
            </span>
        </div>

        {{-- STATUS + PROGRESS --}}
        <div class="sh-card">
            <div class="sh-hd">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <div class="muted small mb-1">
                            <i class="bi bi-hash"></i> Mã đơn hàng
                        </div>
                        <div class="fw-bold mono fs-5">{{ $order->code_order ?? ('#'.$order->id_order) }}</div>
                    </div>
                    <div>
                        <div class="muted small mb-1">
                            <i class="bi bi-calendar3"></i> Ngày đặt
                        </div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    @if(!empty($order->shipping_code))
                        <div>
                            <div class="muted small mb-1">
                                <i class="bi bi-truck"></i> Mã vận đơn
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-semibold mono">{{ $order->shipping_code }}</span>
                                <button class="copy-btn" type="button"
                                        onclick="copyText('{{ $order->shipping_code }}')">
                                    <i class="bi bi-clipboard"></i>
                                    Copy
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-3">
                    <span class="info-badge">
                        <i class="bi bi-info-circle-fill"></i>
                        {{ $status['desc'] }}
                    </span>
                </div>
            </div>

            <div class="sh-bd">
                @if((string)$order->status_order === '9')
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        <strong>Đơn hàng đã bị hủy.</strong>
                    </div>
                @else
                    <div class="progress-steps">
                        <div class="step {{ $stepIndex >= 1 ? 'done' : '' }} {{ $stepIndex == 1 ? 'active' : '' }}">
                            <div class="dot">
                                <i class="bi bi-cart-check"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Đặt hàng</div>
                                <div class="muted small">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="line d-none d-md-block"></div>
                        </div>

                        <div class="step {{ $stepIndex >= 2 ? 'done' : '' }} {{ $stepIndex == 2 ? 'active' : '' }}">
                            <div class="dot">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Xác nhận</div>
                                <div class="muted small">Shop xác nhận</div>
                            </div>
                            <div class="line d-none d-md-block"></div>
                        </div>

                        <div class="step {{ $stepIndex >= 3 ? 'done' : '' }} {{ $stepIndex == 3 ? 'active' : '' }}">
                            <div class="dot">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Đang giao</div>
                                <div class="muted small">
                                    {{ !empty($order->picked_up_at) ? \Carbon\Carbon::parse($order->picked_up_at)->format('d/m/Y H:i') : 'Chưa cập nhật' }}
                                </div>
                            </div>
                            <div class="line d-none d-md-block"></div>
                        </div>

                        <div class="step {{ $stepIndex >= 4 ? 'done' : '' }} {{ $stepIndex == 4 ? 'active' : '' }}">
                            <div class="dot">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Hoàn thành</div>
                                <div class="muted small">
                                    {{ !empty($order->delivered_at) ? \Carbon\Carbon::parse($order->delivered_at)->format('d/m/Y H:i') : 'Chưa cập nhật' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- SHIPPING ADDRESS --}}
        <div class="sh-card">
            <div class="sh-hd">
                <div class="fw-bold">
                    <i class="bi bi-geo-alt-fill text-danger"></i>
                    Địa chỉ nhận hàng
                </div>
            </div>
            <div class="sh-bd">
                <div class="d-flex justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="fw-bold fs-5 mb-2">
                            <i class="bi bi-person-circle text-primary"></i>
                            {{ $order->name_customer }}
                        </div>
                        <div class="muted mb-2">
                            <i class="bi bi-telephone-fill"></i>
                            {{ $order->phone_customer }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-envelope-fill"></i>
                            {{ $order->email_customer }}
                        </div>
                        <div class="mt-2">
                            <i class="bi bi-house-fill text-success"></i>
                            {{ $order->address_detail }},
                            {{ $order->ward }},
                            {{ $order->district }},
                            {{ $order->province }}
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="muted small mb-2">
                            <i class="bi bi-box-seam"></i> Vận chuyển
                        </div>
                        <div class="fw-bold fs-5 text-primary">
                            {{ $order->shipping_unit ?? 'Chưa chọn' }}
                        </div>
                        @if(!empty($order->shipping_code))
                            <div class="muted small mt-2">
                                <i class="bi bi-upc-scan"></i>
                                Mã vận đơn: <span class="mono fw-semibold">{{ $order->shipping_code }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PRODUCTS --}}
        <div class="sh-card">
            <div class="sh-hd d-flex justify-content-between align-items-center">
                <div class="fw-bold">
                    <i class="bi bi-bag-check-fill text-success"></i>
                    Sản phẩm
                </div>
                <div class="info-badge">
                    <i class="bi bi-boxes"></i>
                    {{ $order->orderDetails->count() ?? 0 }} sản phẩm
                </div>
            </div>
            <div class="sh-bd">
                @foreach($order->orderDetails as $detail)
                    @php
                        $p = $detail->product;
                        $img = $p->image ?? 'default.jpg';
                        $lineTotal = ((int)$detail->quantity) * ((int)$detail->price);
                    @endphp

                    <div class="prod-row">
                        <img class="prod-img" src="{{ asset('uploads/product/' . $img) }}"
                             alt="{{ $p->name_product ?? 'Sản phẩm' }}">

                        <div class="flex-grow-1">
                            <div class="fw-bold fs-6 mb-2">{{ $p->name_product ?? 'Sản phẩm' }}</div>

                            @if($detail->productVariant)
                                <div class="mb-2">
                                    @if(!empty($detail->productVariant->size))
                                        <span class="chip">
                                            <i class="bi bi-rulers"></i>
                                            {{ $detail->productVariant->size }}
                                        </span>
                                    @endif
                                    @if(!empty($detail->productVariant->color))
                                        <span class="chip">
                                            <i class="bi bi-palette"></i>
                                            {{ $detail->productVariant->color }}
                                        </span>
                                    @endif
                                    @if(!empty($detail->productVariant->sku))
                                        <span class="chip mono">
                                            <i class="bi bi-upc"></i>
                                            {{ $detail->productVariant->sku }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="muted">
                                    <i class="bi bi-x-lg"></i>
                                    {{ $detail->quantity }}
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-danger fs-5">
                                        {{ number_format($detail->price) }}₫
                                    </div>
                                    <div class="muted small">
                                        Thành tiền: <strong class="text-dark">{{ number_format($lineTotal) }}₫</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- PAYMENT + TOTAL --}}
        <div class="sh-card">
            <div class="sh-hd">
                <div class="fw-bold">
                    <i class="bi bi-credit-card-fill text-info"></i>
                    Thanh toán
                </div>
            </div>
            <div class="sh-bd">
                <div class="d-flex justify-content-between flex-wrap gap-4">
                    <div>
                        <div class="muted small mb-2">
                            <i class="bi bi-wallet2"></i> Phương thức
                        </div>
                        <div class="fw-bold fs-5 mb-3">{{ $paymentMethod }}</div>

                        <div>
                            <span class="badge bg-{{ $paymentClass }}">
                                <i class="bi bi-{{ $paymentClass == 'success' ? 'check-circle-fill' : 'clock-fill' }}"></i>
                                {{ $paymentStatus }}
                            </span>
                            @if(!empty($order->payment_code))
                                <span class="badge bg-light text-dark border ms-2 mono">
                                    <i class="bi bi-receipt"></i>
                                    {{ $order->payment_code }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div style="min-width:340px;">
                        <div class="total-box">
                            <div class="lbl">
                                <i class="bi bi-calculator"></i> Tạm tính
                            </div>
                            <div class="fw-semibold">{{ number_format($subtotal) }}₫</div>
                        </div>
                        <div class="total-box">
                            <div class="lbl">
                                <i class="bi bi-truck"></i> Phí vận chuyển
                            </div>
                            <div class="fw-semibold">{{ number_format($shippingFee) }}₫</div>
                        </div>
                        <div class="total-box">
                            <div class="lbl">
                                <i class="bi bi-percent"></i> Giảm giá
                            </div>
                            <div class="fw-semibold text-success">-{{ number_format($discount) }}₫</div>
                        </div>
                        <hr style="border-top: 2px dashed #dee2e6;">
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <div class="lbl fs-5 fw-bold">
                                <i class="bi bi-cash-coin"></i> Tổng thanh toán
                            </div>
                            <div class="big-total">{{ number_format($grandTotal) }}₫</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="sh-bd pt-0 border-top">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('client.account', ['tab' => 'orders']) }}" class="btn btn-soft">
                        <i class="bi bi-arrow-left-circle"></i>
                        Quay lại danh sách
                    </a>

                    @if((string)$order->status_order === '0')
                        <button class="btn btn-outline-danger" type="button"
                                onclick="cancelOrder({{ $order->id_order }})">
                            <i class="bi bi-x-circle"></i>
                            Hủy đơn
                        </button>
                    @endif

                    @if((string)$order->status_order === '3')
                        <button class="btn btn-outline-success" type="button"
                                onclick="reorder({{ $order->id_order }})">
                            <i class="bi bi-arrow-repeat"></i>
                            Mua lại
                        </button>
                        <button class="btn btn-outline-warning" type="button"
                                onclick="rateOrder({{ $order->id_order }})">
                            <i class="bi bi-star"></i>
                            Đánh giá
                        </button>
                    @endif

                    @if((string)$order->status_order === '2' && !empty($order->shipping_code))
                        <button class="btn btn-outline-primary" type="button"
                                onclick="trackOrder('{{ $order->shipping_code }}')">
                            <i class="bi bi-geo-alt"></i>
                            Theo dõi vận chuyển
                        </button>
                    @endif

                    <button class="btn btn-outline-info" type="button" onclick="printOrder()">
                        <i class="bi bi-printer"></i>
                        In đơn hàng
                    </button>

                    <button class="btn btn-outline-secondary" type="button" onclick="contactSupport()">
                        <i class="bi bi-headset"></i>
                        Liên hệ hỗ trợ
                    </button>
                </div>
            </div>
        </div>

        {{-- HELP SECTION --}}
        <div class="sh-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none;">
            <div class="sh-bd text-center">
                <div class="mb-3">
                    <i class="bi bi-headset display-4 icon-animated"></i>
                </div>
                <h5 class="fw-bold mb-2">Cần hỗ trợ?</h5>
                <p class="mb-3 opacity-75">
                    Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn 24/7
                </p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <button class="btn btn-light" onclick="contactSupport()">
                        <i class="bi bi-chat-dots"></i>
                        Chat ngay
                    </button>
                    <button class="btn btn-outline-light" onclick="callHotline()">
                        <i class="bi bi-telephone"></i>
                        Hotline
                    </button>
                    <button class="btn btn-outline-light" onclick="openFAQ()">
                        <i class="bi bi-question-circle"></i>
                        FAQ
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center muted small mt-4 pb-4">
            <i class="bi bi-shield-check"></i>
            Đơn hàng được bảo vệ bởi chính sách mua hàng an toàn
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="toastMessage">Đã sao chép!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
function showToast(message, type = 'success') {
    const toast = document.getElementById('copyToast');
    const toastMessage = document.getElementById('toastMessage');
    const toastEl = new bootstrap.Toast(toast);
    
    toastMessage.textContent = message;
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toastEl.show();
}

function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Đã sao chép: ' + text);
    }).catch(() => {
        showToast('Không thể sao chép!', 'danger');
    });
}

function cancelOrder(orderId) {
    if(!confirm('Bạn chắc chắn muốn hủy đơn này?\nHành động này không thể hoàn tác!')) return;

    // Show loading
    const loadingToast = showToast('Đang xử lý...', 'info');

    fetch(`/order/cancel/${orderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Hủy đơn hàng thành công!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Có lỗi xảy ra!', 'danger');
        }
    })
    .catch(() => {
        showToast('Có lỗi xảy ra, vui lòng thử lại!', 'danger');
    });
}

function reorder(orderId) {
    if(confirm('Thêm lại tất cả sản phẩm vào giỏ hàng?')) {
        window.location.href = `/order/reorder/${orderId}`;
    }
}

function trackOrder(shippingCode) {
    window.open(`/order/track/${shippingCode}`, '_blank');
}

function rateOrder(orderId) {
    // Redirect to rating page or open modal
    window.location.href = `/order/${orderId}/rate`;
}

function printOrder() {
    window.print();
}

function contactSupport() {
    // Open chat or redirect to support page
    showToast('Đang kết nối với bộ phận hỗ trợ...', 'info');
    // window.location.href = '/support/chat';
}

function callHotline() {
    window.location.href = 'tel:1900-xxxx';
}

function openFAQ() {
    window.location.href = '/faq';
}

// Print styles
window.addEventListener('beforeprint', function() {
    document.querySelectorAll('.btn, .back-btn').forEach(el => {
        el.style.display = 'none';
    });
});

window.addEventListener('afterprint', function() {
    document.querySelectorAll('.btn, .back-btn').forEach(el => {
        el.style.display = '';
    });
});

// Animation on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.sh-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    observer.observe(card);
});
</script>

<style>
@media print {
    .shopee-wrap {
        background: white !important;
    }
    
    .sh-card {
        box-shadow: none !important;
        page-break-inside: avoid;
    }
    
    .btn, .back-btn, .badge {
        display: none !important;
    }
    
    .sh-hd::before {
        display: none;
    }
}
</style>
@endsection