@extends('client.layouts.master')
@section('title', $category->name_category,'nữ công sở cao cấp')
@section('content')
{{-- Hero Banner - Enhanced --}}
<section class="category-hero">
    <div class="hero-overlay"></div>
    <div class="container h-100">
        <div class="hero-content">
            <div class="hero-badge">Bộ sưu tập mới</div>
            <h1 class="hero-title">{{ $category->name_category }}</h1>
            <p class="hero-subtitle">Khám phá phong cách thời trang cao cấp</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <i class="bi bi-box-seam"></i>
                    <span>{{ $products->total() }}+ Sản phẩm</span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-star-fill"></i>
                    <span>Chất lượng cao</span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-truck"></i>
                    <span>Giao hàng nhanh</span>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-shape"></div>
</section>
{{-- Search & Filter Bar --}}
<section class="search-filter-bar">
    <div class="container">
        <div class="search-filter-wrapper">
            <div class="search-box-enhanced">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Tìm kiếm sản phẩm...">
                <button class="search-btn">
                    <span>Tìm kiếm</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
            <div class="quick-filters">
                <button class="filter-chip active">
                    <i class="bi bi-star"></i>
                    Phổ biến
                </button>
                <button class="filter-chip">
                    <i class="bi bi-fire"></i>
                    Giảm giá
                </button>
                <button class="filter-chip">
                    <i class="bi bi-lightning"></i>
                    Mới nhất
                </button>
            </div>
        </div>
    </div>
</section>
{{-- Breadcrumb - Enhanced --}}
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-enhanced">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="bi bi-house-door"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <i class="bi bi-chevron-right"></i>
                </li>
                <li class="breadcrumb-item active">{{ $category->name_category }}</li>
            </ol>
        </nav>
    </div>
</section>
{{-- Main Content --}}
<section class="products-section">
    <div class="container">
        <div class="row">
            {{-- Sidebar Filter - Enhanced --}}
            <div class="col-lg-3">
                <div class="filter-sidebar-enhanced">
                    
                    <div class="filter-header">
                        <h5>
                            <i class="bi bi-funnel"></i>
                            Bộ lọc
                        </h5>
                        <button class="btn-reset">
                            <i class="bi bi-arrow-clockwise"></i>
                            Đặt lại
                        </button>
                    </div>

{{-- Dòng sản phẩm --}}
<div class="filter-section">
    <div class="filter-section-header" data-toggle="collapse">
        <h6>Dòng sản phẩm</h6>
        <i class="bi bi-chevron-down"></i>
    </div>

    <div class="filter-section-content">

        {{-- Đầm --}}
        <label class="filter-checkbox" onclick="window.location='{{ route('client.category', 'dam-cong-so') }}'">
            <input type="checkbox" name="product-line"
                {{ $category->slug_category == 'dam-cong-so' ? 'checked' : '' }}>
            <span class="checkmark"></span>
            <span class="label-text">Đầm</span>
           <span class="count">({{ $counts['dam-cong-so'] }})</span>

        </label>

        {{-- Áo --}}
    <label class="filter-checkbox" onclick="window.location='{{ route('client.category', 'ao') }}'">
    <input type="checkbox" name="product-line"
        {{ $category->slug_category == 'ao' || $category->slug_category == 'ao-khoac-cong-so' ? 'checked' : '' }}>
    <span class="checkmark"></span>
    <span class="label-text">Áo</span>

    {{-- Gộp số lượng 2 danh mục --}}
    <span class="count">({{ 
        ($counts['ao'] ?? 0) + 
        ($counts['ao-khoac-cong-so'] ?? 0) 
    }})</span>
</label>


        {{-- Quần --}}
        <label class="filter-checkbox" onclick="window.location='{{ route('client.category', 'quan') }}'">
            <input type="checkbox" name="product-line"
                {{ $category->slug_category == 'quan' ? 'checked' : '' }}>
            <span class="checkmark"></span>
            <span class="label-text">Quần</span>
            <span class="count">({{ $counts['quan'] }})</span>
        </label>

        {{-- Chân Váy --}}
        <label class="filter-checkbox" onclick="window.location='{{ route('client.category', 'chan-vay') }}'">
            <input type="checkbox" name="product-line"
                {{ $category->slug_category == 'chan-vay' ? 'checked' : '' }}>
            <span class="checkmark"></span>
            <span class="label-text">Chân Váy</span>
            <span class="count">({{ $counts['chan-vay'] }})</span>
        </label>

    </div>
</div>

                    {{-- Giá --}}
                    <div class="filter-section">
                        <div class="filter-section-header" data-toggle="collapse">
                            <h6>Khoảng giá</h6>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="filter-section-content">
                            <div class="price-range-slider">
                                <input type="range" class="range-input" min="0" max="5000000" value="2500000" step="100000">
                                <div class="price-range-values">
                                    <span class="min-price">0đ</span>
                                    <span class="max-price">5,000,000đ</span>
                                </div>
                            </div>
                            <div class="price-presets">
                                <button class="price-preset">Dưới 500k</button>
                                <button class="price-preset">500k - 1tr</button>
                                <button class="price-preset">1tr - 2tr</button>
                                <button class="price-preset">Trên 2tr</button>
                            </div>
                        </div>
                    </div>
                    {{-- Banner Promotion --}}
                    <div class="sidebar-promo">
                        <div class="promo-content">
                            <div class="promo-icon">
                                <i class="bi bi-gift"></i>
                            </div>
                            <h6>Ưu đãi đặc biệt</h6>
                            <p>Giảm ngay 20% cho đơn hàng đầu tiên</p>
                            <button class="btn-promo">Khám phá ngay</button>
                        </div>
                    </div>

                </div>
            </div>
            {{-- Products Grid --}}
            <div class="col-lg-9">
                {{-- Products Header - Enhanced --}}
                <div class="products-header-enhanced">
                    <div class="products-info">
                        <h4>{{ $products->total() }} sản phẩm</h4>
                        <p>Hiển thị <strong>{{ $products->firstItem() }} - {{ $products->lastItem() }}</strong> trong tổng số <strong>{{ $products->total() }}</strong></p>
                    </div>
                    <div class="products-controls">
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                        <select class="sort-select">
                            <option>Mới nhất</option>
                            <option>Bán chạy</option>
                            <option>Giá thấp → cao</option>
                            <option>Giá cao → thấp</option>
                            <option>Tên A → Z</option>
                        </select>
                    </div>
                </div>
                {{-- Products Grid --}}
                <div class="products-grid-enhanced">
                    <div class="row g-4">
                        @foreach($products as $p)
                        <div class="col-6 col-md-4 col-lg-4">
                            <div class="product-card-enhanced">
                                
                                {{-- Image --}}
                                <div class="product-image-container">
                                    <a href="{{ route('client.product.detail', $p->slug_product) }}" class="product-link">
                                        @if(Str::startsWith($p->image, 'http'))
                                            <img src="{{ $p->image }}" alt="{{ $p->name_product }}" class="product-img">
                                        @else
                                            <img src="{{ asset('uploads/product/' . $p->image) }}" alt="{{ $p->name_product }}" class="product-img">
                                        @endif
                                    </a>
                                    {{-- Badges --}}
                                    <div class="product-badges-enhanced">
                                        @if($p->saleprice_product)
                                        <span class="badge-sale">
                                            <i class="bi bi-lightning-fill"></i>
                                            -{{ round((($p->price_product - $p->saleprice_product) / $p->price_product) * 100) }}%
                                        </span>
                                        @endif
                                        @if(rand(0, 1))
                                        <span class="badge-new">New</span>
                                        @endif
                                    </div>
                                    {{-- Quick Actions --}}
                                    <div class="product-actions-enhanced">
                                        <button class="action-btn" title="Yêu thích">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <button class="action-btn" title="Thêm vào giỏ">
                                            <i class="bi bi-bag-plus"></i>
                                        </button>
                                        <button class="action-btn" title="Xem nhanh">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    {{-- Quick Add to Cart --}}
                                    <div class="quick-add-cart">
                                        <button class="btn-quick-add">
                                            <i class="bi bi-cart-plus"></i>
                                            <span>Thêm vào giỏ</span>
                                        </button>
                                    </div>
                                </div>
                                {{-- Info --}}
                                <div class="product-info-enhanced">
                                    
                                    {{-- Rating --}}
                                    <div class="product-rating">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill"></i>
                                            @endfor
                                        </div>
                                        <span class="rating-count">({{ rand(10, 200) }})</span>
                                    </div>

                                    {{-- Name --}}
                                    <h6 class="product-name-enhanced">
                                        <a href="{{ route('client.product.detail', $p->slug_product) }}">
                                            {{ $p->name_product }}
                                        </a>
                                    </h6>
                                    {{-- Colors --}}
                                    @if(isset($p->colors) && count($p->colors) > 0)
                                    <div class="product-colors-enhanced">
                                        <span class="colors-label">Màu sắc:</span>
                                        @foreach($p->colors as $color)
                                        <span class="color-dot-enhanced" style="background: {{ $color }};"></span>
                                        @endforeach
                                    </div>
                                    @endif
                                    {{-- Price --}}
                                    <div class="product-price-enhanced">
                                        @if($p->saleprice_product)
                                            <div class="price-group">
                                                <span class="price-current-enhanced">{{ number_format($p->saleprice_product) }}đ</span>
                                                <span class="price-old-enhanced">{{ number_format($p->price_product) }}đ</span>
                                            </div>
                                            <div class="savings">
                                                Tiết kiệm {{ number_format($p->price_product - $p->saleprice_product) }}đ
                                            </div>
                                        @else
                                            <span class="price-current-enhanced">{{ number_format($p->price_product) }}đ</span>
                                        @endif
                                    </div>

                                    {{-- Sales --}}
                                    <div class="product-sales">
                                        <i class="bi bi-bag-check"></i>
                                        <span>Đã bán {{ rand(50, 500) }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pagination - Enhanced --}}
                <div class="pagination-wrapper-enhanced">
                    {{ $products->links() }}
                </div>

            </div>

        </div>
    </div>
</section>

@endsection

@push('css')
<style>
    .filter-link {
    text-decoration: none;
    color: inherit;
}

/* ===== VARIABLES ===== */
:root {
    --primary-color: #c8a882;
    --primary-dark: #9a7f6f;
    --secondary-color: #333;
    --accent-color: #e74c3c;
    --success-color: #2ecc71;
    --warning-color: #f39c12;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
    --border-color: #ecf0f1;
    --bg-light: #f8f9fa;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
    --shadow-lg: 0 8px 32px rgba(0,0,0,0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== HERO SECTION ===== */
.category-hero {
    background: linear-gradient(135deg, #c8a882 0%, #9a7f6f 100%);
    min-height: 400px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    padding: 80px 0;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-shape {
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 80px;
    background: #fff;
    clip-path: polygon(0 50%, 100% 0, 100% 100%, 0% 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: #fff;
}

.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-title {
    font-size: 56px;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -1px;
    text-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.hero-subtitle {
    font-size: 18px;
    opacity: 0.95;
    margin-bottom: 30px;
    font-weight: 300;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 30px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 500;
}

.stat-item i {
    font-size: 20px;
    opacity: 0.9;
}

/* ===== SEARCH & FILTER BAR ===== */
.search-filter-bar {
    background: #fff;
    box-shadow: var(--shadow-sm);
    position: sticky;
    top: 0;
    z-index: 100;
    padding: 20px 0;
}

.search-filter-wrapper {
    display: flex;
    gap: 20px;
    align-items: center;
}

.search-box-enhanced {
    flex: 1;
    display: flex;
    align-items: center;
    background: var(--bg-light);
    border-radius: 50px;
    padding: 5px 5px 5px 25px;
    border: 2px solid transparent;
    transition: var(--transition);
}

.search-box-enhanced:focus-within {
    border-color: var(--primary-color);
    background: #fff;
    box-shadow: var(--shadow-md);
}

.search-icon {
    color: var(--text-light);
    font-size: 18px;
    margin-right: 15px;
}

.search-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 15px;
    padding: 12px 0;
}

.search-btn {
    background: var(--secondary-color);
    color: #fff;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.search-btn:hover {
    background: var(--primary-color);
    transform: translateX(5px);
}

.quick-filters {
    display: flex;
    gap: 10px;
}

.filter-chip {
    background: #fff;
    border: 2px solid var(--border-color);
    padding: 10px 20px;
    border-radius: 50px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    white-space: nowrap;
}

.filter-chip:hover {
    border-color: var(--primary-color);
    background: var(--bg-light);
}

.filter-chip.active {
    background: var(--secondary-color);
    color: #fff;
    border-color: var(--secondary-color);
}

/* ===== BREADCRUMB ===== */
.breadcrumb-section {
    padding: 20px 0;
    background: #fff;
}

.breadcrumb-enhanced {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
    padding: 0;
    list-style: none;
    font-size: 14px;
}

.breadcrumb-enhanced .breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.breadcrumb-enhanced a {
    color: var(--text-light);
    text-decoration: none;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 5px;
}

.breadcrumb-enhanced a:hover {
    color: var(--primary-color);
}

.breadcrumb-enhanced .active {
    color: var(--text-dark);
    font-weight: 600;
}

/* ===== PRODUCTS SECTION ===== */
.products-section {
    padding: 40px 0 80px;
    background: var(--bg-light);
}

/* ===== FILTER SIDEBAR ===== */
.filter-sidebar-enhanced {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    position: sticky;
    top: 120px;
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 2px solid var(--border-color);
    background: var(--bg-light);
}

.filter-header h5 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
}

.btn-reset {
    background: transparent;
    border: 1px solid var(--border-color);
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 12px;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-reset:hover {
    background: var(--accent-color);
    color: #fff;
    border-color: var(--accent-color);
}

.filter-section {
    border-bottom: 1px solid var(--border-color);
}

.filter-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    cursor: pointer;
    transition: var(--transition);
}

.filter-section-header:hover {
    background: var(--bg-light);
}

.filter-section-header h6 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
}

.filter-section-header i {
    transition: transform 0.3s;
    color: var(--text-light);
}

.filter-section.collapsed .filter-section-header i {
    transform: rotate(-90deg);
}

.filter-section-content {
    padding: 0 20px 20px;
}

/* Custom Checkbox */
.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    cursor: pointer;
    position: relative;
}

.filter-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-color);
    border-radius: 6px;
    transition: var(--transition);
    position: relative;
    flex-shrink: 0;
}

.filter-checkbox input:checked ~ .checkmark {
    background: var(--secondary-color);
    border-color: var(--secondary-color);
}

.filter-checkbox input:checked ~ .checkmark::after {
    content: '\F26E';
    font-family: 'bootstrap-icons';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 12px;
}

.label-text {
    flex: 1;
    font-size: 14px;
    color: var(--text-dark);
}

.count {
    font-size: 13px;
    color: var(--text-light);
}

/* Price Range */
.price-range-slider {
    margin-bottom: 15px;
}

.range-input {
    width: 100%;
    height: 6px;
    border-radius: 5px;
    background: var(--border-color);
    outline: none;
    -webkit-appearance: none;
}

.range-input::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--secondary-color);
    cursor: pointer;
    box-shadow: var(--shadow-sm);
}

.price-range-values {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
}

.price-presets {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-top: 15px;
}

.price-preset {
    background: var(--bg-light);
    border: 1px solid var(--border-color);
    padding: 8px;
    border-radius: 8px;
    font-size: 12px;
    cursor: pointer;
    transition: var(--transition);
}

.price-preset:hover {
    background: var(--secondary-color);
    color: #fff;
    border-color: var(--secondary-color);
}

/* Size Grid */
.size-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
}

.size-option {
    aspect-ratio: 1;
    border: 2px solid var(--border-color);
    background: #fff;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.size-option:hover {
    border-color: var(--primary-color);
    background: var(--bg-light);
}

.size-option.active {
    background: var(--secondary-color);
    color: #fff;
    border-color: var(--secondary-color);
}

/* Color Grid */
.color-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 10px;
}

.color-option {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    border: 2px solid transparent;
}

.color-option:hover {
    transform: scale(1.15);
    box-shadow: var(--shadow-md);
}

.color-option.active::after {
    content: '\F26E';
    font-family: 'bootstrap-icons';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 12px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

/* Sidebar Promo */
.sidebar-promo {
    margin: 20px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.sidebar-promo::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
}

.promo-content {
    position: relative;
    z-index: 2;
}

.promo-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 28px;
}

.sidebar-promo h6 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
}

.sidebar-promo p {
    font-size: 14px;
    opacity: 0.95;
    margin-bottom: 15px;
}

.btn-promo {
    background: #fff;
    color: var(--primary-dark);
    border: none;
    padding: 10px 25px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: var(--transition);
}

.btn-promo:hover {
    background: var(--secondary-color);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* ===== PRODUCTS HEADER ===== */
.products-header-enhanced {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: var(--shadow-sm);
}

.products-info h4 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 5px 0;
}

.products-info p {
    font-size: 14px;
    color: var(--text-light);
    margin: 0;
}

.products-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.view-toggle {
    display: flex;
    background: var(--bg-light);
    border-radius: 10px;
    padding: 4px;
    gap: 4px;
}

.view-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: transparent;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 18px;
    color: var(--text-light);
}

.view-btn:hover {
    background: rgba(0,0,0,0.05);
}

.view-btn.active {
    background: #fff;
    color: var(--secondary-color);
    box-shadow: var(--shadow-sm);
}

.sort-select {
    background: #fff;
    border: 2px solid var(--border-color);
    padding: 10px 40px 10px 15px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
}

.sort-select:focus {
    outline: none;
    border-color: var(--primary-color);
}

/* ===== PRODUCT CARD ENHANCED ===== */
.products-grid-enhanced {
    min-height: 500px;
}

.product-card-enhanced {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-sm);
}

.product-card-enhanced:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-8px);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    padding-top: 125%;
    background: var(--bg-light);
}

.product-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card-enhanced:hover .product-img {
    transform: scale(1.08);
}

.product-badges-enhanced {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 3;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.badge-sale {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.badge-new {
    background: linear-gradient(135deg, var(--success-color) 0%, #27ae60 100%);
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(46, 204, 113, 0.4);
}

.product-actions-enhanced {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 3;
}

.product-card-enhanced:hover .product-actions-enhanced {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 44px;
    height: 44px;
    background: #fff;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 18px;
    color: var(--text-dark);
    box-shadow: var(--shadow-md);
}

.action-btn:hover {
    background: var(--secondary-color);
    color: #fff;
    transform: scale(1.1) rotate(5deg);
}

.quick-add-cart {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 15px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2;
}

.product-card-enhanced:hover .quick-add-cart {
    transform: translateY(0);
}

.btn-quick-add {
    width: 100%;
    background: #fff;
    color: var(--secondary-color);
    border: none;
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-quick-add:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.product-info-enhanced {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
}

.stars {
    color: #ffc107;
    display: flex;
    gap: 2px;
}

.stars i {
    font-size: 13px;
}

.rating-count {
    color: var(--text-light);
    font-weight: 500;
}

.product-name-enhanced {
    font-size: 15px;
    font-weight: 600;
    margin: 0;
    height: 44px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-name-enhanced a {
    color: var(--text-dark);
    text-decoration: none;
    transition: var(--transition);
}

.product-name-enhanced a:hover {
    color: var(--primary-color);
}

.product-colors-enhanced {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
}

.colors-label {
    color: var(--text-light);
    font-weight: 500;
}

.color-dot-enhanced {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px var(--border-color);
    cursor: pointer;
    transition: var(--transition);
}

.color-dot-enhanced:hover {
    transform: scale(1.2);
    box-shadow: 0 0 0 2px var(--primary-color);
}

.product-price-enhanced {
    margin-top: auto;
}

.price-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

.price-current-enhanced {
    font-size: 20px;
    font-weight: 700;
    color: var(--accent-color);
}

.price-old-enhanced {
    font-size: 15px;
    color: var(--text-light);
    text-decoration: line-through;
}

.savings {
    font-size: 12px;
    color: var(--success-color);
    font-weight: 600;
    background: rgba(46, 204, 113, 0.1);
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
}

.product-sales {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-light);
    padding-top: 10px;
    border-top: 1px solid var(--border-color);
}

.product-sales i {
    color: var(--success-color);
}

/* ===== PAGINATION ===== */
.pagination-wrapper-enhanced {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.page-item {
    list-style: none;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
    padding: 0 15px;
    background: #fff;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.page-link:hover {
    background: var(--secondary-color);
    color: #fff;
    border-color: var(--secondary-color);
    transform: translateY(-2px);
}

.page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: #fff;
    box-shadow: var(--shadow-md);
}

.page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1199px) {
    .hero-title {
        font-size: 48px;
    }
    
    .products-grid-enhanced .col-lg-4 {
        width: 33.333%;
    }
}

@media (max-width: 991px) {
    .filter-sidebar-enhanced {
        position: relative;
        top: 0;
        margin-bottom: 30px;
    }
    
    .hero-title {
        font-size: 40px;
    }
    
    .hero-stats {
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .search-filter-wrapper {
        flex-direction: column;
    }
    
    .quick-filters {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 5px;
    }
    
    .products-header-enhanced {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 15px;
    }
    
    .products-controls {
        width: 100%;
        justify-content: space-between;
    }
}

@media (max-width: 767px) {
    .category-hero {
        min-height: 300px;
        padding: 60px 0;
    }
    
    .hero-title {
        font-size: 32px;
    }
    
    .hero-subtitle {
        font-size: 16px;
    }
    
    .hero-stats {
        gap: 15px;
    }
    
    .stat-item {
        font-size: 12px;
    }
    
    .search-box-enhanced {
        padding: 5px;
    }
    
    .search-btn span {
        display: none;
    }
    
    .filter-chip {
        font-size: 13px;
        padding: 8px 15px;
    }
    
    .product-name-enhanced {
        font-size: 14px;
    }
    
    .price-current-enhanced {
        font-size: 18px;
    }
    
    .color-grid {
        grid-template-columns: repeat(6, 1fr);
    }
    
    .view-toggle {
        display: none;
    }
}

@media (max-width: 575px) {
    .hero-title {
        font-size: 28px;
    }
    
    .products-info h4 {
        font-size: 20px;
    }
    
    .product-card-enhanced:hover {
        transform: translateY(-4px);
    }
    
    .price-presets {
        grid-template-columns: 1fr;
    }
}

/* ===== ANIMATIONS ===== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card-enhanced {
    animation: fadeInUp 0.6s ease-out backwards;
}

.product-card-enhanced:nth-child(1) { animation-delay: 0.1s; }
.product-card-enhanced:nth-child(2) { animation-delay: 0.2s; }
.product-card-enhanced:nth-child(3) { animation-delay: 0.3s; }
.product-card-enhanced:nth-child(4) { animation-delay: 0.4s; }

/* ===== LOADING STATE ===== */
.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ===== SCROLL TO TOP ===== */
.scroll-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--secondary-color);
    color: #fff;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
    z-index: 999;
    box-shadow: var(--shadow-lg);
}

.scroll-to-top.show {
    opacity: 1;
    visibility: visible;
}

.scroll-to-top:hover {
    background: var(--primary-color);
    transform: translateY(-5px);
}
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Toggle filter sections
    document.querySelectorAll('.filter-section-header').forEach(header => {
        header.addEventListener('click', function() {
            const section = this.closest('.filter-section');
            const content = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            section.classList.toggle('collapsed');
            
            if (section.classList.contains('collapsed')) {
                content.style.display = 'none';
            } else {
                content.style.display = 'block';
            }
        });
    });
    
    // View toggle
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            const grid = document.querySelector('.products-grid-enhanced .row');
            
            if (view === 'list') {
                grid.classList.add('list-view');
            } else {
                grid.classList.remove('list-view');
            }
        });
    });
    
    // Filter chips
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
    
    // Wishlist button
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('bi-heart')) {
                if (icon.classList.contains('bi-heart-fill')) {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                } else {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                }
            }
        });
    });
    
    // Scroll to top button
    const scrollBtn = document.createElement('button');
    scrollBtn.className = 'scroll-to-top';
    scrollBtn.innerHTML = '<i class="bi bi-arrow-up"></i>';
    document.body.appendChild(scrollBtn);
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollBtn.classList.add('show');
        } else {
            scrollBtn.classList.remove('show');
        }
    });
    
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Price range update
    const rangeInput = document.querySelector('.range-input');
    if (rangeInput) {
        rangeInput.addEventListener('input', function() {
            const maxPrice = document.querySelector('.max-price');
            if (maxPrice) {
                maxPrice.textContent = new Intl.NumberFormat('vi-VN').format(this.value) + 'đ';
            }
        });
    }
    
    // Add to cart animation
    document.querySelectorAll('.btn-quick-add').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-circle-fill"></i><span>Đã thêm!</span>';
            this.style.background = '#2ecc71';
            this.style.color = '#fff';
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.background = '';
                this.style.color = '';
            }, 2000);
        });
    });
});
</script>
@endpush