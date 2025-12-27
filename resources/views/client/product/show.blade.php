@extends('client.layouts.master')
@section('title', $product->name)

@push('styles')
<style>
/* ===== ENHANCED COMPLETE STYLES ===== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Arial', sans-serif;
    background: #fafafa;
    color: #1a1a1a;
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* ===== BREADCRUMB ===== */
.breadcrumb-section {
    padding: 16px 0;
    background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    border-bottom: 1px solid #e8e8e8;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #666;
    list-style: none;
}

.breadcrumb a {
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.breadcrumb a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: #000;
    transition: width 0.3s ease;
}

.breadcrumb a:hover {
    color: #000;
}

.breadcrumb a:hover::after {
    width: 100%;
}

.breadcrumb-separator {
    color: #999;
}

/* ===== PRODUCT DETAIL WRAPPER ===== */
.product-detail-wrapper {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    animation: fadeIn 0.6s ease-out;
}

.product-detail-container {
    display: grid;
    grid-template-columns: 500px 1fr;
    gap: 60px;
    margin-bottom: 60px;
}

/* ===== PRODUCT GALLERY ===== */
.product-gallery {
    display: flex;
    gap: 15px;
    position: relative;
}

.thumbnail-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 500px;
    overflow-y: auto;
}

.thumbnail-item {
    width: 70px;
    height: 90px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    cursor: pointer;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.thumbnail-item:hover {
    border-color: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.thumbnail-item.active {
    border-color: #000;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.main-image-container {
    flex: 1;
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    position: relative;
}

.main-image-container:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.main-image {
    width: 100%;
    height: 500px;
    object-fit: contain;
    cursor: zoom-in;
    transition: transform 0.5s ease;
}

.main-image:hover {
    transform: scale(1.05);
}

/* ===== PRODUCT INFO ===== */
.product-info {
    padding-top: 10px;
}

.product-title {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    margin-bottom: 15px;
    line-height: 1.4;
}

.product-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.product-sku {
    font-size: 13px;
    color: #666;
    font-weight: 500;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.stars {
    color: #ffc107;
    font-size: 14px;
}

.rating-count {
    font-size: 13px;
    color: #666;
}

.stock-status {
    font-size: 13px;
    color: #28a745;
    font-weight: 500;
}

/* ===== PRICE SECTION ===== */
.price-section {
    background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 25px;
    border: 2px solid #ffe0e0;
    position: relative;
    overflow: hidden;
}

.price-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
    transform: rotate(45deg);
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.current-price {
    font-size: 36px;
    font-weight: 800;
    color: #d72027;
    position: relative;
}

.original-price {
    font-size: 18px;
    color: #999;
    text-decoration: line-through;
    margin-left: 10px;
}

/* ===== PAYMENT INFO ===== */
.payment-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.payment-info::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.payment-info-icon {
    font-size: 24px;
    position: relative;
    z-index: 1;
}

.payment-info-text {
    font-size: 14px;
    line-height: 1.5;
    position: relative;
    z-index: 1;
}

.payment-info-link {
    color: #fff;
    text-decoration: underline;
    font-weight: 600;
}

/* ===== OPTIONS GROUP ===== */
.option-group {
    margin-bottom: 25px;
}

.option-label {
    font-size: 14px;
    font-weight: 600;
    color: #000;
    margin-bottom: 12px;
    display: block;
}

/* ===== COLOR OPTIONS ===== */
.color-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.color-option {
    min-width: 80px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    background: #fff;
    padding: 0 15px;
}

.color-option:hover {
    border-color: #333;
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

.color-option.active {
    background: #000;
    color: #fff;
    border-color: #000;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

/* ===== SIZE OPTIONS ===== */
.size-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.size-option {
    min-width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    background: #ffffff;
}

.size-option:hover:not(.disabled) {
    border-color: #333;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

.size-option.active {
    background: linear-gradient(135deg, #000 0%, #333 100%);
    color: #fff;
    border-color: #000;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
}

.size-option.disabled {
    opacity: 0.4;
    pointer-events: none;
    background: #f5f5f5;
    position: relative;
}

.size-option.disabled::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 5%;
    right: 5%;
    height: 2px;
    background: #999;
    transform: translateY(-50%);
}

/* ===== QUANTITY SECTION ===== */
.quantity-section {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.quantity-control:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.qty-btn {
    width: 45px;
    height: 45px;
    border: none;
    background: #f9f9f9;
    cursor: pointer;
    font-size: 18px;
    font-weight: 700;
    transition: all 0.2s ease;
}

.qty-btn:hover {
    background: #333;
    color: #fff;
    transform: scale(1.1);
}

.qty-btn:active {
    transform: scale(0.95);
}

.qty-input {
    width: 60px;
    height: 45px;
    border: none;
    text-align: center;
    font-weight: 600;
    font-size: 16px;
    background: #fff;
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
}

.btn-wishlist {
    width: 50px;
    height: 50px;
    border: 2px solid #e0e0e0;
    background: #fff;
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

.btn-wishlist:hover {
    border-color: #d72027;
    color: #d72027;
    transform: translateY(-3px) rotate(5deg);
    box-shadow: 0 6px 20px rgba(215, 32, 39, 0.2);
}

.btn-add-cart {
    flex: 1;
    height: 50px;
    border: 2px solid #000;
    background: #fff;
    color: #000;
    font-weight: 600;
    font-size: 15px;
    border-radius: 12px;
    cursor: pointer;
    text-transform: uppercase;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.btn-add-cart::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(0,0,0,0.05);
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
}

.btn-add-cart:hover::before {
    width: 300%;
    height: 300%;
}

.btn-add-cart:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-buy-now {
    flex: 1;
    height: 50px;
    border: none;
    background: linear-gradient(135deg, #000 0%, #333 100%);
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    border-radius: 12px;
    cursor: pointer;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.btn-buy-now::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: rotate(45deg);
    transition: all 0.5s;
}

.btn-buy-now:hover::after {
    left: 100%;
}

.btn-buy-now:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    background: linear-gradient(135deg, #1a1a1a 0%, #444 100%);
}

.btn-buy-now:active {
    transform: translateY(-1px);
}

/* ===== ACCORDION ===== */
.info-accordion {
    border-top: 1px solid #eee;
}

.accordion-item {
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin-bottom: 8px;
}

.accordion-item:hover {
    background: #fafafa;
}

.accordion-header {
    padding: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    user-select: none;
}

.accordion-header:hover {
    color: #666;
}

.accordion-icon {
    transition: transform 0.3s;
    font-size: 20px;
}

.accordion-item.active .accordion-icon {
    transform: rotate(45deg);
    color: #d72027;
}

.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.accordion-item.active .accordion-content {
    max-height: 500px;
    padding-bottom: 20px;
}

.accordion-content p {
    color: #666;
    line-height: 1.8;
    font-size: 14px;
}

/* ===== REVIEWS SECTION ===== */
.reviews-section {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid #eee;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 30px;
}

.reviews-summary {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px;
    border-radius: 12px;
    margin-bottom: 30px;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.rating-overview {
    display: flex;
    gap: 60px;
    align-items: center;
}

.rating-score {
    text-align: center;
}

.rating-number {
    font-size: 48px;
    font-weight: 700;
    line-height: 1;
}

.rating-stars {
    color: #ffc107;
    font-size: 18px;
    margin: 10px 0;
}

.rating-breakdown {
    flex: 1;
}

.rating-bar {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
}

.rating-bar-label {
    font-size: 13px;
    color: #666;
    min-width: 50px;
}

.rating-bar-track {
    flex: 1;
    height: 8px;
    background: #e0e0e0;
    border-radius: 4px;
    overflow: hidden;
}

.rating-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
}

.rating-bar-count {
    font-size: 13px;
    color: #666;
    min-width: 30px;
    text-align: right;
}

/* ===== RELATED PRODUCTS ===== */
.related-products {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid #eee;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 25px;
}

/* ===== SUGGEST ITEMS ===== */
.suggest-item {
    display: flex;
    gap: 10px;
    padding: 15px;
    background: #fff;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.suggest-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-color: #e0e0e0;
}

.suggest-item img {
    width: 100px;
    height: auto;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.suggest-item:hover img {
    transform: scale(1.05);
}

.suggest-info {
    flex: 1;
}

.suggest-info .name {
    font-size: 14px;
    margin-bottom: 4px;
    font-weight: 500;
}

.suggest-info .name a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.suggest-info .name a:hover {
    color: #d72027;
}

.suggest-info .price {
    color: #d72027;
    font-weight: 600;
    font-size: 16px;
}

/* ===== LOADING ANIMATION ===== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .product-detail-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .product-gallery {
        flex-direction: column-reverse;
    }

    .thumbnail-list {
        flex-direction: row;
        max-height: none;
        overflow-x: auto;
    }

    .rating-overview {
        flex-direction: column;
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .product-title {
        font-size: 22px;
    }

    .current-price {
        font-size: 28px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-add-cart, .btn-buy-now {
        font-size: 14px;
        height: 48px;
    }

    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
}

@media (max-width: 576px) {
    .product-detail-wrapper {
        padding: 0 15px;
    }

    .main-image {
        height: 350px;
    }

    .color-options,
    .size-options {
        gap: 8px;
    }
}
</style>
@endpush
@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-separator">›</li>
            <li><a href="/category/{{ $product->category->slug_category }}">{{ $product->category->name_category }}</a></li>
            <li class="breadcrumb-separator">›</li>
           <li>{{ $product->name_product }}</li>

        </ul>
    </div>
</div>

<!-- Product Detail -->
<div class="product-detail-wrapper">
    <div class="product-detail-container">
        <!-- Gallery Section -->
        <div class="product-gallery">
    <div class="thumbnail-list">
    @foreach($product->images as $index => $img)
        <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}">
            <img
                src="{{ asset('uploads/product/' . $img->image_url) }}"
                alt="{{ $product->name_product }}"
            >
        </div>
    @endforeach
</div>

            <div class="main-image-container">
                <img
    src="{{ asset('uploads/product/' . ($product->images->first()->image_url ?? $product->image)) }}"
    alt="{{ $product->name_product }}"
    class="main-image"
    id="mainImage"
>

            </div>
        </div>

        <!-- Product Info Section -->
        <div class="product-info">
            <h1 class="product-title">{{ $product->name_product }}</h1>
            
            <div class="product-meta">
                <span class="product-sku">SKU: {{ $product->code_product }}</span>
                <div class="product-rating">
                    <div class="stars">★★★★★</div>
                    <span class="rating-count">(0)</span>
                </div>
                <span class="stock-status">0 Nhận xét</span>
            </div>

            <div class="price-section">
                <span class="current-price">{{ number_format($product->saleprice_product) }}đ</span>
            </div>

            <div class="payment-info">
                <div class="payment-info-icon">🎁</div>
                <div class="payment-info-text">
                    Giảm đến <strong>60K</strong> thanh toán qua <strong>Fundiin</strong>, <a href="#" class="payment-info-link">xem thêm</a>
                </div>
            </div>

            <!-- Color Selection -->
            <div class="option-group">
                <label class="option-label">Màu sắc:</label>
<div class="color-options">
    @foreach($colors as $color)
        <div
            class="color-option"
            data-color="{{ $color }}"
            title="{{ $color }}"
        >
            {{ $color }}
        </div>
    @endforeach
</div>

            </div>

            <!-- Size Selection -->
<div class="option-group">
    <label class="option-label">Size:</label>
    <div class="size-options">
        @foreach($sizes as $size_product => $quantity)
            <div 
                class="size-option {{ $quantity == 0 ? 'disabled' : '' }}"
                data-size="{{ $size_product }}"
                data-qty="{{ $quantity }}"
            >
                {{ $size_product }}
            </div>
        @endforeach
    </div>
</div>


            <!-- Quantity -->
            <div class="quantity-section">
                <label class="option-label">Số lượng:</label>
                <div class="quantity-control">
                    <button type="button" class="qty-btn" onclick="changeQuantity(-1)">−</button>
                    <input type="text" class="qty-input" id="quantityInput" value="1" readonly>
                    <button type="button" class="qty-btn" onclick="changeQuantity(1)">+</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn-wishlist" title="Thêm vào yêu thích">
                    <i class="fa fa-heart-o"></i>
                </button>
                <form action="{{ route('client.cart.add') }}" method="POST" id="addToCartForm">
    @csrf

    <input type="hidden" name="id_product_variant" id="variant_id">
    <input type="hidden" name="quantity" value="1">

    <button type="submit" class="btn-add-cart">
        Thêm vào giỏ hàng
    </button>
</form>

                
                <a href="{{ route('client.checkout') }}" class="btn btn-danger w-95 b-2">
    MUA NGAY
</a>
            </div>

            <!-- Accordion Info -->
            <div class="info-accordion">
<div class="accordion-item">
    <div class="accordion-header" onclick="toggleAccordion(this)">
        <span>Thông tin chi tiết</span>
        <span class="accordion-icon">+</span>
    </div>

    <div class="accordion-content">
        <p>{{ $product->describe_product }}</p>
    </div>
</div>

                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Bảng size</span>
                        <span class="accordion-icon">+</span>
                    </div>
<div class="accordion-content">
    @foreach($variants as $variant)
        <p>
            Size: {{ $variant->size }} |
            Màu: {{ $variant->color }} |
            Tồn: {{ $variant->stock }}
        </p>
    @endforeach
</div>

                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h2 class="section-title">Đánh giá sản phẩm</h2>
        <div class="reviews-summary">
            <div class="rating-overview">
                <div class="rating-score">
                    <div class="rating-number">0.0</div>
                    <div class="rating-stars">★★★★★</div>
                    <div style="font-size: 13px; color: #666; margin-top: 5px;">/ 5</div>
                </div>
                <div class="rating-breakdown">
                    <div class="rating-bar">
                        <span class="rating-bar-label">5 sao</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: 0%"></div>
                        </div>
                        <span class="rating-bar-count">(0)</span>
                    </div>
                    <div class="rating-bar">
                        <span class="rating-bar-label">4 sao</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: 0%"></div>
                        </div>
                        <span class="rating-bar-count">(0)</span>
                    </div>
                    <div class="rating-bar">
                        <span class="rating-bar-label">3 sao</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: 0%"></div>
                        </div>
                        <span class="rating-bar-count">(0)</span>
                    </div>
                    <div class="rating-bar">
                        <span class="rating-bar-label">2 sao</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: 0%"></div>
                        </div>
                        <span class="rating-bar-count">(0)</span>
                    </div>
                    <div class="rating-bar">
                        <span class="rating-bar-label">1 sao</span>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: 0%"></div>
                        </div>
                        <span class="rating-bar-count">(0)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products">
        <h2 class="section-title">CÓ THỂ BẠN SẼ THÍCH</h2>
        <div class="products-grid">
            <!-- Example product cards - replace with your actual data -->
    @foreach($suggestProducts as $product)
        <div class="suggest-item">
            <a href="{{ route('client.product.detail', $product->slug_product) }}">
                <img src="{{ asset('uploads/product/' . $product->image) }}"
                     alt="{{ $product->name_product }}">
            </a>

            <div class="suggest-info">
                <p class="name">
                    <a href="{{ route('client.product.detail', $product->slug_product) }}">
                        {{ $product->name_product }}
                    </a>
                </p>

                <p class="price">
                    {{ number_format($product->saleprice_product ?? $product->price_product) }}đ
                </p>
            </div>
        </div>
    @endforeach
            <!-- Repeat for more products -->
        </div>
    </div>
</div>

@push('scripts')
<script>
const variants = @json($variants);
let selectedSize = null;
let selectedColor = null;

const variantInput = document.getElementById('variant_id');
const qtyHiddenInput = document.querySelector('input[name="quantity"]');
const qtyDisplayInput = document.getElementById('quantityInput');

function findVariant() {
    if (!selectedSize || !selectedColor) return;

    const variant = variants.find(v =>
        v.size === selectedSize && v.color === selectedColor
    );

    if (variant) {
        variantInput.value = variant.id_product_variant;
        console.log('Selected variant:', variant.id_product_variant);
    }
}

// Chọn size
document.querySelectorAll('.size-option:not(.disabled)').forEach(el => {
    el.addEventListener('click', function () {
        document.querySelectorAll('.size-option').forEach(s => s.classList.remove('active'));
        this.classList.add('active');
        selectedSize = this.dataset.size;
        findVariant();
    });
});

// Chọn màu
document.querySelectorAll('.color-option').forEach(el => {
    el.addEventListener('click', function () {
        document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        selectedColor = this.dataset.color;
        findVariant();
    });
});

// ✅ Hàm thay đổi số lượng - ĐÃ SỬA
function changeQuantity(amount) {
    const input = document.getElementById('quantityInput');
    let currentValue = parseInt(input.value) || 1;
    let newValue = currentValue + amount;
    
    if (newValue < 1) newValue = 1;
    
    input.value = newValue;
    
    // ✅ QUAN TRỌNG: Cập nhật giá trị vào input hidden
    qtyHiddenInput.value = newValue;
    
    console.log('Quantity updated to:', newValue);
}

// Thumbnail Click
document.querySelectorAll('.thumbnail-item').forEach(thumb => {
    thumb.addEventListener('click', function() {
        const imgSrc = this.querySelector('img').src;
        document.getElementById('mainImage').src = imgSrc;
        
        document.querySelectorAll('.thumbnail-item').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});

// Accordion toggle
function toggleAccordion(element) {
    const item = element.parentElement;
    const icon = element.querySelector('.accordion-icon');
    
    item.classList.toggle('active');
    icon.textContent = item.classList.contains('active') ? '−' : '+';
}
</script>
@endpush
@endsection