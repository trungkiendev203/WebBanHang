@extends('client.layouts.master')

@section('title', 'Tìm kiếm: ' . $keyword)

@section('content')
<div class="container py-5">

    <h2 class="mb-4">Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>

    @if ($products->count() == 0)
        <p>Không tìm thấy sản phẩm nào phù hợp.</p>
    @else

    <div class="row g-4">
        @foreach ($products as $product)
        <div class="col-6 col-md-3">
            <div class="product-card">

                {{-- IMAGE --}}
                <div class="product-image">
                    @if(Str::startsWith($product->image, 'http'))
                        <img src="{{ $product->image }}" alt="{{ $product->name_product }}">
                    @else
                        <img src="{{ asset('uploads/product/' . $product->image) }}" 
                             alt="{{ $product->name_product }}">
                    @endif
                </div>

                {{-- INFO --}}
                <div class="product-info">
                    <h5>{{ $product->name_product }}</h5>

                    <div class="product-price">
                        @if($product->saleprice_product)
                            <span class="price-old">{{ number_format($product->price_product) }}đ</span>
                            <span class="price-current text-danger">{{ number_format($product->saleprice_product) }}đ</span>
                        @else
                            <span class="price-current">{{ number_format($product->price_product) }}đ</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->appends(['q' => $keyword])->links() }}
    </div>

    @endif

</div>
@endsection
