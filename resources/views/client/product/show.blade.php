@extends('client.layouts.master')
@section('title', $product->name)

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background: #fff;
        color: #333;
    }

    /* ===== BREADCRUMB ===== */
    .breadcrumb-section {
        padding: 20px 0;
        background: #f9f9f9;
        border-bottom: 1px solid #eee;
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
        transition: color 0.3s;
    }

    .breadcrumb a:hover {
        color: #000;
    }

    .breadcrumb-separator {
        color: #999;
    }

    /* ===== PRODUCT DETAIL ===== */
    .product-detail-wrapper {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .product-detail-container {
        display: grid;
        grid-template-columns: 500px 1fr;
        gap: 60px;
        margin-bottom: 60px;
    }

    /* Gallery Section */
    .product-gallery {
        display: flex;
        gap: 15px;
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
        border-radius: 8px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s;
    }

    .thumbnail-item:hover,
    .thumbnail-item.active {
        border-color: #000;
    }

    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-image-container {
        flex: 1;
        position: relative;
        background: #f9f9f9;
        border-radius: 12px;
        overflow: hidden;
    }

    .main-image {
        width: 100%;
        height: 500px;
        object-fit: contain;
        cursor: zoom-in;
    }

    /* Product Info Section */
    .product-info {
        padding-top: 10px;
    }

    .product-title {
        font-size: 24px;
        font-weight: 600;
        color: #000;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .product-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .product-sku {
        font-size: 13px;
        color: #666;
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
    }

    /* Price Section */
    .price-section {
        margin-bottom: 25px;
    }

    .current-price {
        font-size: 32px;
        font-weight: 700;
        color: #d72027;
    }

    .original-price {
        font-size: 18px;
        color: #999;
        text-decoration: line-through;
        margin-left: 10px;
    }

    /* Payment Info */
    .payment-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
    }

    .payment-info-icon {
        font-size: 24px;
    }

    .payment-info-text {
        font-size: 14px;
        line-height: 1.5;
    }

    .payment-info-link {
        color: #fff;
        text-decoration: underline;
        font-weight: 600;
    }

    /* Color Selector */
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

    .color-options {
        display: flex;
        gap: 10px;
    }

    .color-option {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .color-option:hover,
    .color-option.active {
        border-color: #000;
        transform: scale(1.1);
    }

    .color-option.active::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-weight: bold;
    }

    /* Size Selector */
    .size-options {
        display: flex;
        gap: 10px;
    }

    .size-option {
        min-width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        padding: 0 15px;
    }

    .size-option:hover {
        border-color: #666;
    }

    .size-option.active {
        background: #000;
        color: #fff;
        border-color: #000;
    }

    /* Quantity Selector */
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
        border-radius: 8px;
        overflow: hidden;
    }

    .qty-btn {
        width: 45px;
        height: 45px;
        border: none;
        background: #f9f9f9;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s;
    }

    .qty-btn:hover {
        background: #eee;
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

    /* Action Buttons */
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
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s;
    }

    .btn-wishlist:hover {
        border-color: #d72027;
        color: #d72027;
    }

    .btn-add-cart {
        flex: 1;
        height: 50px;
        border: 2px solid #000;
        background: #fff;
        color: #000;
        font-weight: 600;
        font-size: 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
    }

    .btn-add-cart:hover {
        background: #f9f9f9;
    }

    .btn-buy-now {
        flex: 1;
        height: 50px;
        border: none;
        background: #000;
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
    }

    .btn-buy-now:hover {
        background: #333;
    }

    /* Accordion Sections */
    .info-accordion {
        border-top: 1px solid #eee;
    }

    .accordion-item {
        border-bottom: 1px solid #eee;
    }

    .accordion-header {
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
    }

    .accordion-header:hover {
        color: #666;
    }

    .accordion-icon {
        transition: transform 0.3s;
    }


    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
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
        background: #f9f9f9;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 30px;
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
        background: #ffc107;
        border-radius: 4px;
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

    .product-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid #f0f0f0;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .product-card-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
        background: #f9f9f9;
    }

    .product-card-info {
        padding: 15px;
    }

    .product-card-title {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }

    .product-card-colors {
        display: flex;
        gap: 5px;
        margin-bottom: 10px;
    }

    .product-card-color {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 1px solid #e0e0e0;
    }

    .product-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-card-price {
        font-size: 16px;
        font-weight: 700;
        color: #d72027;
    }

    .product-card-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #666;
    }

    .product-card-rating .stars {
        color: #ffc107;
        font-size: 12px;
    }

    /* Responsive */
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

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .product-title {
            font-size: 20px;
        }

        .current-price {
            font-size: 26px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .rating-overview {
            flex-direction: column;
            gap: 30px;
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
                <div class="thumbnail-item active">
                    <img src="{{ asset('uploads/product/' . $product->image) }}" alt="Thumbnail 1">
                </div>
                <!-- Add more thumbnails if you have multiple images -->
            </div>
            <div class="main-image-container">
                <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}" class="main-image" id="mainImage">
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
                <span class="current-price">{{ number_format($product->import_price) }}đ</span>
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
                    <div class="color-option active" style="background: #fff;" data-color="white"></div>
                    <div class="color-option" style="background: #c41e3a;" data-color="red"></div>
                    <div class="color-option" style="background: #000;" data-color="black"></div>
                </div>
            </div>

            <!-- Size Selection -->
            <div class="option-group">
                <label class="option-label">Size:</label>
                <div class="size-options">
                    <div class="size-option" data-size="S">S</div>
                    <div class="size-option" data-size="M">M</div>
                    <div class="size-option active" data-size="L">L</div>
                    <div class="size-option" data-size="XL">XL</div>
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
                <button class="btn-add-cart">Thêm vào giỏ hàng</button>
                <button class="btn-buy-now">Mua ngay</button>
            </div>

            <!-- Accordion Info -->
            <div class="info-accordion">
<div class="accordion-item">
    <div class="accordion-header" onclick="toggleAccordion(this)">
        <span>Thông tin chi tiết</span>
        <span class="accordion-icon">+</span>
    </div>

    <div class="accordion-content">
        <p>{{ $product->description_product }}</p>
    </div>
</div>

                <div class="accordion-item">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Bảng size</span>
                        <span class="accordion-icon">+</span>
                    </div>
                    <div class="accordion-content">
                        <p>Thông tin bảng size sẽ được cập nhật...</p>
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
            <div class="product-card">
                <img src="{{ asset('uploads/product/' . $product->image) }}" alt="Product" class="product-card-image">
                <div class="product-card-info">
                    <h3 class="product-card-title">Đầm cổ tròn xẻ nách 2 hàng khuyên</h3>
                    <div class="product-card-colors">
                        <span class="product-card-color" style="background: #c8a882;"></span>
                        <span class="product-card-color" style="background: #000;"></span>
                    </div>
                    <div class="product-card-footer">
                        <span class="product-card-price">875,000đ</span>
                        <div class="product-card-rating">
                            <span class="stars">★★★★★</span>
                            <span>(0)</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Repeat for more products -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleAccordion(header) {
    const item = header.parentElement;
    const icon = header.querySelector('.accordion-icon');

    const isOpen = item.classList.contains('active');

    // đóng tất cả accordion khác (nếu muốn)
    document.querySelectorAll('.accordion-item').forEach(i => {
        i.classList.remove('active');
        i.querySelector('.accordion-icon').innerText = '+';
    });

    // mở accordion được bấm
    if (!isOpen) {
        item.classList.add('active');
        icon.innerText = '−';
    }
}
// Quantity Control
function changeQuantity(amount) {
    const input = document.getElementById('quantityInput');
    let currentValue = parseInt(input.value) || 1;
    let newValue = currentValue + amount;
    
    if (newValue < 1) newValue = 1;
    
    input.value = newValue;
}



// Color Selection
document.querySelectorAll('.color-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.color-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
    });
});

// Size Selection
document.querySelectorAll('.size-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.size-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
    });
});

// Thumbnail Click
document.querySelectorAll('.thumbnail-item').forEach(thumb => {
    thumb.addEventListener('click', function() {
        const imgSrc = this.querySelector('img').src;
        document.getElementById('mainImage').src = imgSrc;
        
        document.querySelectorAll('.thumbnail-item').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endpush

@endsection