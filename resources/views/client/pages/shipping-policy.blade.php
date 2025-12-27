@extends('client.layouts.master')

@section('title', 'Chính sách vận chuyển')

@section('content')
<div class="container py-4">

    {{-- BREADCRUMB --}}
    <nav class="breadcrumb mb-3">
        <a href="{{ route('home') }}">Trang chủ</a>
        <span>/</span>
        <span>Chính sách vận chuyển</span>
    </nav>

    <div class="row">
        {{-- LEFT SIDEBAR --}}
<div class="col-md-3">
    <h6 class="mb-3 fw-semibold">CÓ THỂ BẠN QUAN TÂM</h6>

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
</div>


        {{-- MAIN CONTENT --}}
        <div class="col-md-9">
            <h2 class="fw-bold mb-2">CHÍNH SÁCH VẬN CHUYỂN</h2>
            <p class="text-muted mb-4">Cập nhật: {{ date('d/m/Y') }}</p>

            <div class="policy-content">
                <p>
                    <strong>SWEETIE</strong> hỗ trợ giao hàng toàn quốc. Khách hàng có thể lựa chọn
                    một trong các hình thức thanh toán khi đặt hàng như sau:
                </p>

                <ul>
                    <li>
                        Thanh toán khi nhận hàng (COD) trên toàn quốc.
                    </li>
                    <li>
                        Thanh toán chuyển khoản trước toàn bộ giá trị đơn hàng và phí vận chuyển.
                    </li>
                    <li>
                        Phí vận chuyển được áp dụng theo bảng giá của đơn vị vận chuyển hợp tác.
                    </li>
                    <li>
                        Đối với khách hàng nội thành Hà Nội, đơn hàng có thể được giao trong ngày.
                    </li>
                    <li>
                        Đối với khách hàng online, GMOON hỗ trợ đổi hàng trong vòng 30 ngày.
                    </li>
                </ul>

                <p>
                    Trong trường hợp phát sinh sự cố về vận chuyển hoặc giao hàng chậm trễ,
                    quý khách vui lòng liên hệ bộ phận chăm sóc khách hàng để được hỗ trợ nhanh nhất.
                </p>

                <p>
                    👉 Tham khảo thêm:
                    <a href="#">
                        Chính sách đổi trả
                    </a>
                </p>
                <img src="{{ asset('uploads/products/sample-product.jpg') }}" alt="">
            </div>
        </div>
    </div>

</div>
@push('styles')
<style>
.breadcrumb {
    font-size: 14px;
}

.breadcrumb a {
    text-decoration: none;
    color: #555;
}

.breadcrumb span {
    margin: 0 5px;
}

.suggest-item {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.suggest-item img {
    width: 70px;
    height: auto;
    border-radius: 4px;
}

.suggest-info .name {
    font-size: 14px;
    margin-bottom: 4px;
}

.suggest-info .price {
    color: #d0021b;
    font-weight: 600;
}

.policy-content {
    font-size: 15px;
    line-height: 1.7;
}

.policy-content ul {
    padding-left: 18px;
}

.policy-content li {
    margin-bottom: 8px;
}

.policy-content a {
    color: #d0021b;
    text-decoration: none;
}

</style>
@endpush
@endsection
