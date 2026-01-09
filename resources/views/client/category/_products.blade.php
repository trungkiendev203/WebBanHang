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
<form method="GET" class="products-controls-form">
    {{-- Giữ lại toàn bộ filter cũ (trừ sort & page) --}}
    @foreach(request()->except('sort', 'page') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <select name="sort" class="sort-select" onchange="this.form.submit()">
        <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>
            Mới nhất
        </option>

        <option value="best_seller" {{ request('sort')=='best_seller' ? 'selected' : '' }}>
            Bán chạy
        </option>

        <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>
            Giá thấp → cao
        </option>

        <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>
            Giá cao → thấp
        </option>

        <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>
            Tên A → Z
        </option>
    </select>
</form>


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
                                    
                                        <a href="{{ route('client.product.detail', $p->slug_product) }}">
                                            @php
                                                $img = $p->images->first();
                                                $src = $img ? $img->image_url : $p->image;
                                            @endphp
<img
    src="{{ Str::startsWith($src, 'http') ? $src : asset('uploads/product/'.$src) }}"
    class="product-img"
    alt="{{ $p->name_product }}"
>

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
@auth
    <button class="action-btn btn-wishlist" title="Yêu thích" data-id="{{ $p->id_product }}">
        <i class="bi bi-heart"></i>
    </button>
@else
    <button class="action-btn" title="Yêu thích"
        onclick="alert('Vui lòng đăng nhập để sử dụng chức năng yêu thích')">
        <i class="bi bi-heart"></i>
    </button>
@endauth

                                        <!-- <button class="action-btn" title="Thêm vào giỏ">
                                            <i class="bi bi-bag-plus"></i>
                                        </button> -->
                                        <button class="action-btn" title="Xem nhanh">
                                            <i class="bi bi-eye"></i>
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
    <span>Đã bán {{ $p->sold ?? 0 }}</span>

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
            {{-- End Products Grid --}}