@extends('client.layouts.master')


@section('title', 'SWEETIE - Thời trang cao cấp')

@section('content')

{{-- ===========================
     HERO BANNER SLIDER
============================ --}}
<section class="hero-section">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">

            @foreach ($banners as $banner)
                <div class="swiper-slide position-relative">
                    <img src="{{ asset('uploads/banner/' . $banner->image) }}" class="w-100">

                    @if (!empty($banner->title))
                        <div class="banner-text">
                            <h2>{{ $banner->title }}</h2>
                            @if (!empty($banner->link))
                                <a href="{{ $banner->link }}" class="btn btn-outline-light mt-3">Xem thêm</a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach

        </div>

        {{-- CHỈ DÙNG 1 pagination + navigation --}}
        <div class="swiper-pagination"></div>

    </div>
</section>


{{-- ===========================
     SEARCH BAR (giống JM)
=========================== --}}
<section class="home-search-bar py-3">
    <div class="container">
        <form action="{{ route('client.search') }}" method="GET" class="search-box-home">
            <input type="text" name="keyword" placeholder="Bạn muốn tìm sản phẩm gì ?" required>
            <button type="submit">Tìm kiếm ngay</button>
        </form>
    </div>
</section>


{{-- ===========================
     CATEGORY ICONS
============================ --}}
<section class="category-section py-5">
    <div class="container">
        <div class="category-wrapper">
            <div class="category-row">
                <!-- ĐẦM -->
                <div class="category-item">
                    <a href="{{ route('client.category', 'dam-cong-so') }}" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/dam.png') }}" alt="Đầm">
                        </div>
                        <span class="category-name">ĐẦM</span>
                    </a>
                </div>
                
                <!-- ÁO -->
                <div class="category-item">
                    <a href="{{ route('client.category', 'ao') }}" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/ao.png') }}" alt="Áo">
                        </div>
                        <span class="category-name">ÁO</span>
                    </a>
                </div>
                
                <!-- QUẦN -->
                <div class="category-item">
                    <a href="{{ route('client.category', 'quan') }}" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/quan.png') }}" alt="Quần">
                        </div>
                        <span class="category-name">QUẦN</span>
                    </a>
                </div>
                
                <!-- CHÂN VÁY -->
                <div class="category-item">
                    <a href="{{ route('client.category', 'chan-vay') }}" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/chan_vay.png') }}" alt="Chân váy">
                        </div>
                        <span class="category-name">CHÂN VÁY</span>
                    </a>
                </div>
                
                <!-- ÁO KHOÁC -->
                <div class="category-item">
                    <a href="{{ route('client.category', 'ao-khoac-cong-so') }}" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/ao_khoac.png') }}" alt="Áo khoác">
                        </div>
                        <span class="category-name">ÁO KHOÁC</span>
                    </a>
                </div>
                
                <!-- SALE -->
                <div class="category-item">
                    <a href="{{ route('client.sale') }}" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/sale.png') }}" alt="Sale">
                        </div>
                        <span class="category-name">SALE</span>
                    </a>
                </div>
            
            <!-- QUÀ TẶNG ở giữa -->
            <div class="category-row-center">
                <div class="category-item">
                    <a href="#" class="category-link">
                        <div class="category-circle">
                            <img src="{{ asset('uploads/categories/sale.png') }}" alt="Quà tặng">
                        </div>
                        <span class="category-name">QUÀ TẶNG</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===========================
     COLLECTION BANNERS (2x3 Grid)
============================ --}}
<section class="collection-banners py-5">
    <div class="container">
        <div class="row g-3">

            @foreach ($collections as $item)
                <div class="col-md-6">
                    <a href="{{ route('client.collection.show', $item->slug) }}" class="text-decoration-none">
                        <div class="collection-card"
                            style="
                                background:
                                linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)),
                                url('{{ asset('uploads/collections/' . $item->banner) }}')
                                center/cover;
                            ">

                            <div class="collection-overlay">
                               

                                @if (!empty($item->description))
                                    <p class="text-white">{{ $item->description }}</p>
                                @endif

                                <span class="btn-discover">Khám phá →</span>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</section>




{{-- ===========================
     FEATURED PRODUCTS (SẢN PHẨM BÁN CHẠY)
============================ --}}
<section class="featured-products py-5 bg-light">
    <div class="container">
        
        <div class="section-header text-center mb-5">
            <h2>SẢN PHẨM BÁN CHẠY</h2>
            <div class="divider"></div>
        </div>

        <div class="row g-4">

            @foreach($new_products as $product)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="product-card">

                   <div class="product-image">

@php
    $img = $product->images->first();
    $src = $img ? $img->image_url : $product->image;
@endphp

<img
    src="{{ Str::startsWith($src, 'http') ? $src : asset('uploads/product/'.$src) }}"
    class="product-image"
    alt="{{ $product->name_product }}"
>



    <div class="product-badges">
        @if($product->saleprice_product > 0)
            <span class="badge badge-sale">
                -{{ 100 - floor(($product->saleprice_product / $product->price_product) * 100) }}%
            </span>
        @endif

        <span class="badge badge-new">NEW</span>
    </div>

    <div class="product-actions">
        <button class="btn-action" title="Yêu thích">
            <i class="bi bi-heart"></i>
        </button>
        <button class="btn-action" title="Xem nhanh">
           <a href="{{ route('client.product.show', ['slug' => $product->slug_product]) }}">
    <i class="bi bi-eye"></i>
</a>

        </button>
    </div>

</div>

                    {{-- THÔNG TIN SẢN PHẨM --}}
                    
                    <div class="product-info">
                        <h5 class="product-name">
                            {{ $product->name_product }}
                        </h5>

                        {{-- Đánh giá giả --}}
                        <div class="product-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span>(128)</span>
                        </div>x
                        {{-- GIÁ --}}
                        <div class="product-price">
                            @if($product->saleprice_product > 0)
                                <span class="price-old">
                                    {{ number_format($product->price_product, 0, ',', '.') }}đ
                                </span>
                                <span class="price-current text-danger">
                                    {{ number_format($product->saleprice_product, 0, ',', '.') }}đ
                                </span>
                            @else
                                <span class="price-current">
                                    {{ number_format($product->price_product, 0, ',', '.') }}đ
                                </span>
                            @endif
                        </div>

                        {{-- MÀU SẮC (fake vì chưa có bảng màu) --}}
                        <div class="product-colors">
                            <span class="color-dot" style="background:#2c3e50;"></span>
                            <span class="color-dot" style="background:#fff; border:1px solid #ddd;"></span>
                            <span class="color-dot" style="background:#e74c3c;"></span>
                        </div>

                    </div>

                </div>
            </div>
            @endforeach

        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-dark btn-lg">XEM TẤT CẢ SẢN PHẨM</a>
        </div>

    </div>
</section>


@endsection


@push('js')
<script>
    document.querySelectorAll('.size-option').forEach(el => {
    el.addEventListener('click', () => {
        document.querySelectorAll('.size-option')
            .forEach(s => s.classList.remove('active'));

        el.classList.add('active');
        selectedSize = el.dataset.size;
    });
});

new Swiper(".heroSwiper", {
    loop: true,
    autoplay: {
        delay: 2000, // 🔥 tự chạy 2 giây
        disableOnInteraction: false
    },
    pagination: {
        el: ".heroSwiper .swiper-pagination",
        clickable: true
    },
    navigation: {
        nextEl: ".heroSwiper .swiper-button-next",
        prevEl: ".heroSwiper .swiper-button-prev"
    },
    effect: 'fade',
    fadeEffect: { crossFade: true }
});
</script>
@endpush
