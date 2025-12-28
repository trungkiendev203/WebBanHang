@extends('client.layouts.master')

@section('title', $collection->name)

@section('content')

{{-- HERO BANNER --}}
@if($collection->banner)
    <div class="hero-banner">
        <img src="{{ asset('uploads/collections/'.$collection->banner) }}" alt="{{ $collection->name }}">
        <div class="hero-overlay">
            <div class="hero-content">
                
                @if($collection->description)
                    <p class="hero-subtitle">{{ $collection->description }}</p>
                @endif
            </div>
        </div>
        <div class="hero-gradient"></div>
    </div>
@endif

<div class="collection-container">
    {{-- SEARCH & FILTER BAR --}}
    <div class="search-filter-bar">
        <div class="search-box">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" placeholder="Tìm kiếm sản phẩm..." class="search-input">
        </div>
        <button class="btn-filter">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="4" y1="21" x2="4" y2="14"></line>
                <line x1="4" y1="10" x2="4" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12" y2="3"></line>
                <line x1="20" y1="21" x2="20" y2="16"></line>
                <line x1="20" y1="12" x2="20" y2="3"></line>
                <line x1="1" y1="14" x2="7" y2="14"></line>
                <line x1="9" y1="8" x2="15" y2="8"></line>
                <line x1="17" y1="16" x2="23" y2="16"></line>
            </svg>
            Bộ lọc
        </button>
        <button class="btn-discount">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            Giảm giá
        </button>
        <button class="btn-new">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            Mới nhất
        </button>
    </div>

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-wrapper">
        <a href="{{ url('/') }}" class="breadcrumb-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Trang chủ
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">{{ $collection->name }}</span>
    </div>

    <div class="content-layout">
        {{-- MAIN CONTENT --}}
        <main class="main-content">
            {{-- Toolbar --}}
            <div class="product-toolbar">
                <div class="toolbar-left">
                    <h2 class="section-title">{{ $products->total() }} sản phẩm</h2>
                    <p class="section-subtitle">Hiển thị 1 - {{ $products->count() }} trong tổng số {{ $products->total() }}</p>
                </div>
                <div class="toolbar-right">
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </button>
                        <button class="view-btn" data-view="list">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <select class="sort-select">
                        <option value="">Mới nhất</option>
                        <option value="price-asc">Giá: Thấp đến cao</option>
                        <option value="price-desc">Giá: Cao đến thấp</option>
                        <option value="popular">Phổ biến nhất</option>
                        <option value="discount">Giảm giá nhiều</option>
                    </select>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="products-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <a href="{{ route('client.product.show', $product->slug_product) }}" class="product-link">
<img
    src="{{ asset(
        $product->images->first()
            ? 'uploads/product/'.$product->images->first()->image_url
            : 'uploads/product/'.$product->image
    ) }}"
    class="product-image"
>

                            </a>

                            {{-- Badges --}}
                            <div class="badges">
                                @if(isset($product->discount) && $product->discount > 0)
                                    <span class="badge badge-sale">-{{ $product->discount }}%</span>
                                @endif
                                @if(isset($product->is_new) && $product->is_new)
                                    <span class="badge badge-new">NEW</span>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="product-actions">
                                <button class="action-btn btn-wishlist" title="Yêu thích">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn btn-quickview" title="Xem nhanh">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>

                            
                        </div>

                        <div class="product-info">
                            {{-- Rating --}}
                            <div class="product-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= ($product->rating ?? 5) ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <span class="rating-count">({{ $product->reviews_count ?? 189 }})</span>
                            </div>

                            {{-- Name --}}
                            <a href="{{ route('client.product.show', $product->slug_product) }}" class="product-name">
                                {{ $product->name_product }}
                            </a>

                            {{-- Price --}}
                            <div class="product-price">
                                <span class="price-current">{{ number_format($product->price_product) }}đ</span>
                                @if(isset($product->original_price) && $product->original_price > $product->price_product)
                                    <span class="price-original">{{ number_format($product->original_price) }}đ</span>
                                @endif
                            </div>

                            @if(isset($product->savings))
                                <p class="savings-text">Tiết kiệm {{ number_format($product->savings) }}đ</p>
                            @endif

                            {{-- Stock Status --}}
                            <div class="stock-status">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                </svg>
                                Đã bán {{ $product->total_sold ?? 0 }}



                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg class="empty-icon" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 6v6m0 4h.01"></path>
                        </svg>
                        <h3>Không tìm thấy sản phẩm</h3>
                        <p>Thử điều chỉnh bộ lọc hoặc tìm kiếm khác</p>
                        <a href="{{ route('client.home') }}" class="btn-home">Về trang chủ</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </main>
    </div>
</div>

@endsection

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #1a1a1a;
        --secondary: #666;
        --accent: #00d9ff;
        --accent-dark: #00b8d4;
        --sale: #ff3d00;
        --success: #00c853;
        --border: #e8e8e8;
        --bg-light: #f5f7fa;
        --shadow-sm: 0 2px 12px rgba(0,0,0,0.04);
        --shadow-md: 0 8px 24px rgba(0,0,0,0.08);
        --shadow-lg: 0 16px 48px rgba(0,0,0,0.12);
        --shadow-glow: 0 0 24px rgba(0,217,255,0.2);
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    /* HERO BANNER */
    .hero-banner {
        position: relative;
        height: 500px;
        overflow: hidden;
        border-radius: 0 0 60px 60px;
        margin-bottom: 4rem;
        box-shadow: var(--shadow-lg);
    }

    .hero-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        animation: kenburns 20s ease infinite alternate;
    }

    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: none;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .hero-gradient {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 150px;
        background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
        pointer-events: none;
    }

    .hero-content {
        text-align: center;
        color: white;
        z-index: 1;
        animation: fadeInUp 1s ease;
    }

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

    .hero-title {
        font-size: 4rem;
        font-weight: 200;
        letter-spacing: 12px;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        background: linear-gradient(to right, #fff, #00d9ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        font-weight: 300;
        letter-spacing: 3px;
        opacity: 0.95;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    /* CONTAINER */
    .collection-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 5rem;
    }

    /* SEARCH & FILTER BAR */
    .search-filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2.5rem;
        padding: 1.5rem;
        background: white;
        border-radius: 24px;
        box-shadow: var(--shadow-md);
        backdrop-filter: blur(10px);
        animation: slideDown 0.6s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .search-box {
        flex: 1;
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--secondary);
        transition: all 0.3s;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3.5rem;
        border: 2px solid var(--border);
        border-radius: 50px;
        font-size: 0.95rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--bg-light);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: var(--shadow-glow);
        background: white;
        transform: translateY(-2px);
    }

    .search-input:focus + .search-icon {
        color: var(--accent);
    }

    .btn-filter,
    .btn-discount,
    .btn-new {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0 1.75rem;
        border: 2px solid var(--border);
        background: white;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .btn-filter::before,
    .btn-discount::before,
    .btn-new::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        opacity: 0;
        transition: opacity 0.4s;
    }

    .btn-filter:hover,
    .btn-discount:hover,
    .btn-new:hover {
        color: white;
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: var(--shadow-glow);
    }

    .btn-filter:hover::before,
    .btn-discount:hover::before,
    .btn-new:hover::before {
        opacity: 1;
    }

    .btn-filter svg,
    .btn-discount svg,
    .btn-new svg {
        position: relative;
        z-index: 1;
        transition: all 0.3s;
    }

    .btn-filter:hover svg,
    .btn-discount:hover svg,
    .btn-new:hover svg {
        stroke: white;
        transform: rotate(10deg);
    }

    .btn-filter span,
    .btn-discount span,
    .btn-new span {
        position: relative;
        z-index: 1;
    }

    /* BREADCRUMB */
    .breadcrumb-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2.5rem;
        font-size: 0.9rem;
        color: var(--secondary);
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--secondary);
        text-decoration: none;
        transition: all 0.3s;
        padding: 0.5rem 0.75rem;
        border-radius: 12px;
    }

    .breadcrumb-item:hover {
        color: var(--accent);
        background: rgba(0,217,255,0.1);
    }

    .breadcrumb-current {
        color: var(--primary);
        font-weight: 600;
    }

    /* MAIN CONTENT */
    .main-content {
        min-width: 0;
    }

    /* TOOLBAR */
    .product-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.75rem 2rem;
        background: white;
        border-radius: 24px;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-md);
        animation: fadeIn 1s ease;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-subtitle {
        font-size: 0.9rem;
        color: var(--secondary);
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .view-toggle {
        display: flex;
        gap: 0.5rem;
        padding: 0.35rem;
        background: var(--bg-light);
        border-radius: 14px;
    }

    .view-btn {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .view-btn.active {
        background: white;
        box-shadow: var(--shadow-sm);
        transform: scale(1.05);
    }

    .view-btn:hover:not(.active) {
        background: rgba(0,217,255,0.1);
    }

    .view-btn.active svg {
        stroke: var(--accent);
    }

    .sort-select {
        padding: 0.85rem 1.75rem;
        border: 2px solid var(--border);
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
    }

    .sort-select:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: var(--shadow-glow);
    }

    /* PRODUCTS GRID */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 4rem;
    }

    /* PRODUCT CARD */
    .product-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .product-card::before {
        content: '';
        position: absolute;
        inset: -2px;
        background: linear-gradient(135deg, var(--accent), transparent);
        border-radius: 24px;
        opacity: 0;
        transition: opacity 0.5s;
        z-index: -1;
    }

    .product-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-8px);
    }

    .product-card:hover::before {
        opacity: 0.3;
    }

    .product-image-wrapper {
        position: relative;
        padding-top: 133.33%;
        background: linear-gradient(135deg, #f5f7fa, #e8ecf1);
        overflow: hidden;
    }

    .product-image,
    .product-image-hover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-image-hover {
        transform: scale(1.1);
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
        opacity: 90;
    }

    .product-card:hover .product-image-hover {
        opacity: 1;
        transform: scale(1);
    }

    /* BADGES */
    .badges {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 2;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        backdrop-filter: blur(10px);
        animation: bounceIn 0.6s ease;
    }

    @keyframes bounceIn {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    .badge-sale {
        background: linear-gradient(135deg, #ff3d00, #ff6e40);
        color: white;
        box-shadow: 0 4px 12px rgba(255,61,0,0.4);
    }

    .badge-new {
        background: linear-gradient(135deg, var(--success), #00e676);
        color: white;
        box-shadow: 0 4px 12px rgba(0,200,83,0.4);
    }

    /* ACTIONS */
    .product-actions {
        position: absolute;
        top: 1.25rem;
        left: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        opacity: 0;
        transform: translateX(-30px);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
    }

    .product-card:hover .product-actions {
        opacity: 1;
        transform: translateX(0);
    }

    .action-btn {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.95);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: var(--shadow-md);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .action-btn:hover {
        background: var(--accent);
        transform: scale(1.15) rotate(10deg);
        box-shadow: var(--shadow-glow);
    }

    .action-btn:hover svg {
        stroke: white;
    }

    .action-btn.active {
        background: var(--sale);
    }

    .action-btn.active svg {
        fill: white;
        stroke: white;
        animation: heartbeat 0.6s ease;
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(1.1); }
    }

    /* QUICK CART */
    .btn-quick-cart {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.25rem;
        background: linear-gradient(135deg, rgba(26,26,26,0.95), rgba(0,0,0,0.95));
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        cursor: pointer;
        opacity: 0;
        transform: translateY(100%);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
        backdrop-filter: blur(10px);
    }

    .product-card:hover .btn-quick-cart {
        opacity: 1;
        transform: translateY(0);
    }

    .btn-quick-cart:hover {
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        box-shadow: 0 -4px 20px rgba(0,217,255,0.4);
    }

    .btn-quick-cart svg {
        transition: transform 0.3s;
    }

    .btn-quick-cart:hover svg {
        transform: scale(1.2);
    }

    .btn-quick-cart.added {
        background: linear-gradient(135deg, var(--success), #00e676);
    }

    /* PRODUCT INFO */
    .product-info {
        padding: 1.5rem;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #e0e0e0;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .star.filled {
        color: #ffc107;
        text-shadow: 0 2px 4px rgba(255,193,7,0.3);
        animation: starPulse 2s ease infinite;
    }

    @keyframes starPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .rating-count {
        font-size: 0.85rem;
        color: var(--secondary);
        font-weight: 500;
    }

    .product-name {
        display: block;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        margin-bottom: 1rem;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: all 0.3s;
    }

    .product-name:hover {
        color: var(--accent);
        transform: translateX(3px);
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .price-current {
        font-size: 1.4rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--sale), #ff6e40);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .price-original {
        font-size: 1rem;
        color: var(--secondary);
        text-decoration: line-through;
        opacity: 0.7;
    }

    .savings-text {
        font-size: 0.9rem;
        color: var(--success);
        font-weight: 700;
        margin-bottom: 0.75rem;
        padding: 0.35rem 0.75rem;
        background: rgba(0,200,83,0.1);
        border-radius: 8px;
        display: inline-block;
    }

    .stock-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--secondary);
        padding: 0.5rem;
        background: var(--bg-light);
        border-radius: 10px;
        font-weight: 500;
    }

    .stock-status svg {
        stroke: var(--accent);
    }

    /* EMPTY STATE */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 6rem 2rem;
        animation: fadeIn 1s ease;
    }

    .empty-icon {
        margin: 0 auto 2rem;
        stroke: var(--border);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .empty-state h3 {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        color: var(--primary);
    }

    .empty-state p {
        color: var(--secondary);
        margin-bottom: 2.5rem;
        font-size: 1.05rem;
    }

    .btn-home {
        display: inline-block;
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-md);
    }

    .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-glow);
    }

    /* PAGINATION */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 4rem;
        animation: fadeIn 1.2s ease;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.75rem;
        list-style: none;
    }

    .pagination-wrapper .page-link {
        min-width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 1rem;
        border: 2px solid var(--border);
        background: white;
        color: var(--primary);
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pagination-wrapper .page-link:hover {
        background: var(--accent);
        color: white;
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: var(--shadow-glow);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: white;
        border-color: var(--accent);
        box-shadow: var(--shadow-glow);
    }

    /* LOADING ANIMATION */
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .hero-banner {
            height: 350px;
            border-radius: 0 0 40px 40px;
        }

        .hero-title {
            font-size: 2.5rem;
            letter-spacing: 6px;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .collection-container {
            padding: 0 1rem 3rem;
        }

        .search-filter-bar {
            flex-wrap: wrap;
            padding: 1rem;
            gap: 0.75rem;
        }

        .search-box {
            width: 100%;
            order: -1;
        }

        .product-toolbar {
            flex-direction: column;
            gap: 1.25rem;
            align-items: flex-start;
            padding: 1.25rem;
        }

        .toolbar-right {
            width: 100%;
            flex-wrap: wrap;
        }

        .sort-select {
            flex: 1;
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .product-actions,
        .btn-quick-cart {
            opacity: 1;
            transform: none;
        }

        .action-btn {
            width: 40px;
            height: 40px;
        }

        .badge {
            padding: 0.4rem 0.75rem;
            font-size: 0.7rem;
        }

        .product-info {
            padding: 1rem;
        }

        .product-name {
            font-size: 0.95rem;
        }

        .price-current {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 1.8rem;
            letter-spacing: 3px;
        }

        .products-grid {
            grid-template-columns: 1fr;
        }

        .btn-filter,
        .btn-discount,
        .btn-new {
            font-size: 0.85rem;
            padding: 0 1.25rem;
        }
    }

    /* SCROLL ANIMATIONS */
    .product-card {
        animation: fadeInUp 0.6s ease backwards;
    }

    .product-card:nth-child(1) { animation-delay: 0.1s; }
    .product-card:nth-child(2) { animation-delay: 0.2s; }
    .product-card:nth-child(3) { animation-delay: 0.3s; }
    .product-card:nth-child(4) { animation-delay: 0.4s; }
    .product-card:nth-child(5) { animation-delay: 0.5s; }
    .product-card:nth-child(6) { animation-delay: 0.6s; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Wishlist toggle with animation
        document.querySelectorAll('.btn-wishlist').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('active');
                
                if(this.classList.contains('active')) {
                    // Create heart particles
                    for(let i = 0; i < 6; i++) {
                        createHeartParticle(this);
                    }
                }
            });
        });

        // Create heart particle effect
        function createHeartParticle(button) {
            const particle = document.createElement('div');
            particle.innerHTML = '❤';
            particle.style.cssText = `
                position: absolute;
                font-size: 12px;
                pointer-events: none;
                animation: particleFloat 1s ease-out forwards;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                color: #ff3d00;
                z-index: 1000;
            `;
            
            button.style.position = 'relative';
            button.appendChild(particle);
            
            setTimeout(() => particle.remove(), 1000);
        }

        // Add particle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes particleFloat {
                0% {
                    transform: translate(-50%, -50%) scale(0);
                    opacity: 1;
                }
                100% {
                    transform: translate(
                        calc(-50% + ${Math.random() * 60 - 30}px),
                        calc(-50% - ${Math.random() * 60 + 20}px)
                    ) scale(1.5);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Quick add to cart with enhanced animation
        document.querySelectorAll('.btn-quick-cart').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const originalHTML = this.innerHTML;
                this.classList.add('added');
                this.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Đã thêm!
                `;
                
                // Haptic feedback simulation
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
                
                setTimeout(() => {
                    this.classList.remove('added');
                    this.innerHTML = originalHTML;
                }, 2500);
            });
        });

        // View toggle with smooth transition
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.dataset.view;
                const grid = document.querySelector('.products-grid');
                
                grid.style.opacity = '0';
                grid.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    if(view === 'list') {
                        grid.style.gridTemplateColumns = '1fr';
                    } else {
                        grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(300px, 1fr))';
                    }
                    
                    grid.style.opacity = '1';
                    grid.style.transform = 'scale(1)';
                }, 200);
            });
        });

        // Sort change with loading effect
        document.querySelector('.sort-select')?.addEventListener('change', function() {
            const grid = document.querySelector('.products-grid');
            grid.style.opacity = '0.5';
            grid.style.filter = 'blur(2px)';
            
            // Simulate API call
            setTimeout(() => {
                grid.style.opacity = '1';
                grid.style.filter = 'blur(0)';
                console.log('Sort by:', this.value);
            }, 500);
        });

        // Search input animation
        const searchInput = document.querySelector('.search-input');
        searchInput?.addEventListener('input', function() {
            if(this.value.length > 0) {
                this.style.paddingRight = '3rem';
            } else {
                this.style.paddingRight = '1rem';
            }
        });

        // Smooth scroll reveal for products
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.product-card').forEach(card => {
            observer.observe(card);
        });

        // Add transition styles for grid
        const gridStyle = document.createElement('style');
        gridStyle.textContent = `
            .products-grid {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
        `;
        document.head.appendChild(gridStyle);
    });
</script>
@endpush