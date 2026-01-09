@extends('client.layouts.master')

@section('title', $event->title)

@section('content')
<div class="event-products-page">
    <div class="container py-5">

        {{-- HEADER SECTION --}}
        <div class="event-header text-center mb-5">
            <div class="event-badge mb-3">
                <span class="badge bg-gradient-primary px-4 py-2 rounded-pill">
                    <i class="fas fa-calendar-star me-2"></i>Sự Kiện Đặc Biệt
                </span>
            </div>
            <h1 class="event-title fw-bold mb-3">{{ $event->title }}</h1>
            @if(!empty($event->subtitle))
                <p class="event-subtitle text-muted fs-5">{{ $event->subtitle }}</p>
            @endif
            <div class="title-divider mx-auto"></div>
        </div>

        {{-- PRODUCTS GRID --}}
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            @php
                                $img = $product->images->first();
                                $src = $img ? $img->image_url : null;
                            @endphp
                            <img
                                src="{{ $src ? asset('uploads/product/'.$src) : asset('images/no-image.png') }}"
                                class="product-image"
                                alt="{{ $product->name_product }}"
                            >
                            <div class="product-overlay">
                                <a href="{{ route('client.product.detail', $product->slug_product) }}" 
                                   class="btn btn-light rounded-pill px-4">
                                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                                </a>
                            </div>
                            <div class="product-badge">
                                <span class="badge bg-danger">Hot</span>
                            </div>
                        </div>

                        <div class="product-info">
                            <h6 class="product-name mb-2">
                                <a href="{{ route('client.product.detail', $product->slug_product) }}">
                                    {{ $product->name_product }}
                                </a>
                            </h6>
                            <div class="product-price">
                                <span class="current-price">{{ number_format($product->price_product) }}đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-box-open fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-2">Chưa có sản phẩm</h4>
                        <p class="text-secondary">Hiện tại chưa có sản phẩm nào cho sự kiện này.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

<style>
/* Event Header Styles */
.event-products-page {
    background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
    min-height: 100vh;
}

.event-header {
    position: relative;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.event-title {
    font-size: 2.5rem;
    color: #2d3748;
    letter-spacing: -0.5px;
}

.event-subtitle {
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.title-divider {
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, #667eea, #764ba2);
    border-radius: 2px;
    margin-top: 1rem;
}

/* Product Card Styles */
.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    padding-top: 100%;
    overflow: hidden;
    background: #f7fafc;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-overlay .btn {
    transform: translateY(10px);
    transition: transform 0.3s ease;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.product-card:hover .product-overlay .btn {
    transform: translateY(0);
}

.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 1;
}

.product-badge .badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 12px;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
}

.product-info {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-name {
    font-size: 0.95rem;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 0.75rem;
    min-height: 2.8em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-name a {
    color: #2d3748;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: #667eea;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.current-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #dc2626;
}

/* Empty State */
.empty-state {
    background: white;
    border-radius: 16px;
    padding: 3rem 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.empty-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .event-title {
        font-size: 1.75rem;
    }
    
    .event-subtitle {
        font-size: 1rem;
    }
    
    .product-card {
        border-radius: 12px;
    }
}

@media (max-width: 576px) {
    .event-title {
        font-size: 1.5rem;
    }
    
    .product-info {
        padding: 1rem;
    }
    
    .current-price {
        font-size: 1.1rem;
    }
}
</style>
@endsection