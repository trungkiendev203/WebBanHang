@extends('client.layouts.master')

@section('title', 'Thanh toán')

@section('content')
<style>
    .checkout-wrapper {
        background: #f5f5f5;
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        font-size: 14px;
    }
    
    .breadcrumb-nav a {
        color: #666;
        text-decoration: none;
    }
    
    .breadcrumb-nav a:hover {
        color: #000;
    }
    
    .breadcrumb-nav span {
        color: #000;
        font-weight: 500;
    }
    
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        align-items: start;
    }
    
    .checkout-form {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #222;
    }
    
    .login-prompt {
        background: #fff9e6;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 25px;
        font-size: 14px;
    }
    
    .login-prompt a {
        color: #d4a027;
        font-weight: 600;
        text-decoration: none;
        margin-left: 5px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #000;
    }
    
    .form-input::placeholder {
        color: #999;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    
    .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        min-height: 100px;
        resize: vertical;
        font-family: inherit;
    }
    
    .form-textarea:focus {
        outline: none;
        border-color: #000;
    }
    
    .payment-section {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #eee;
    }
    
    .payment-method {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 18px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }
    
    .payment-method:hover {
        border-color: #000;
        background: #fafafa;
    }
    
    .payment-method input[type="radio"] {
        margin-top: 3px;
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #000;
    }
    
    .payment-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff3cd;
        border-radius: 6px;
        font-size: 24px;
    }
    
    .payment-details h4 {
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 5px 0;
        color: #222;
    }
    
    .payment-details p {
        font-size: 13px;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }
    
    .payment-note {
        margin-top: 15px;
        font-size: 13px;
        color: #666;
        line-height: 1.6;
    }
    
    .payment-note a {
        color: #d4a027;
        text-decoration: none;
        font-weight: 500;
    }
    
    .order-summary {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
    }
    
    .product-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .product-item:first-child {
        padding-top: 0;
    }
    
    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
        background: #f5f5f5;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-quantity {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #666;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
    }
    
    .product-info {
        flex: 1;
    }
    
    .product-title {
        font-size: 14px;
        font-weight: 500;
        color: #222;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    
    .product-title a {
        color: #222;
        text-decoration: none;
    }
    
    .product-title a:hover {
        color: #d4a027;
    }
    
    .product-meta {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .product-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 2px;
    }
    
    .quantity-control button {
        background: none;
        border: none;
        width: 28px;
        height: 28px;
        cursor: pointer;
        color: #666;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }
    
    .quantity-control button:hover {
        color: #000;
    }
    
    .quantity-control input {
        width: 35px;
        text-align: center;
        border: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    .product-price {
        font-size: 15px;
        font-weight: 600;
        color: #e63946;
    }
    
    .discount-section {
        margin: 20px 0;
        padding: 20px 0;
        border-top: 1px solid #f0f0f0;
    }
    
    .discount-input-group {
        display: flex;
        gap: 10px;
    }
    
    .discount-input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
    
    .btn-apply {
        padding: 12px 24px;
        background: #000;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        white-space: nowrap;
    }
    
    .btn-apply:hover {
        background: #333;
    }
    
    .order-total {
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }
    
    .total-row.subtotal {
        color: #666;
    }
    
    .total-row.discount {
        color: #28a745;
    }
    
    .total-row.shipping {
        color: #666;
    }
    
    .total-row.final {
        font-size: 18px;
        font-weight: 700;
        color: #000;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
        margin-top: 15px;
    }
    
    .total-row.final .amount {
        color: #e63946;
    }
    
    .btn-checkout {
        width: 100%;
        padding: 16px;
        background: #000;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 20px;
        letter-spacing: 0.5px;
    }
    
    .btn-checkout:hover {
        background: #333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        
        .order-summary {
            position: static;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="checkout-wrapper">
    <div class="checkout-container">
        <div class="breadcrumb-nav">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span>›</span>
            <span>Thanh toán</span>
        </div>
        
        <div class="checkout-grid">
            <div class="checkout-form">
                <h2 class="section-title">Thông tin giao hàng</h2>
                
                <div class="login-prompt">
                    Bạn đã có tài khoản?
                    <a href="#">Đăng nhập</a> ngay để nhận ưu đãi
                </div>
                
                <form action="{{ route('client.checkout.store') }}" method="POST">

                    @csrf
@foreach($items as $item)
    <input type="hidden"
           name="cart[{{ $item['id_product_variant'] }}][id_product_variant]"
           value="{{ $item['id_product_variant'] }}">

    <input type="hidden"
           name="cart[{{ $item['id_product_variant'] }}][quantity]"
           value="{{ $item['quantity'] }}">
@endforeach

                    <div class="form-group">
                        <label class="form-label">Tên</label>
                        <input type="text" name="name_customer" class="form-input" 
                               placeholder="Họ và tên" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Điện thoại</label>
                        <input type="tel" name="phone_customer" class="form-input" 
                               placeholder="Số điện thoại" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Địa chỉ Email</label>
                        <input type="email" name="email_customer" class="form-input" 
                               placeholder="Địa chỉ Email">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address_detail" class="form-input" 
                               placeholder="Địa chỉ" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <select name="province" id="province" class="form-input" required>
    <option value="">Tỉnh/TP</option>
</select>
                        </div>
                        
                        <div class="form-group">
<select name="district" id="district" class="form-input" required>
    <option value="">Quận/Huyện</option>
</select>
                        </div>
                        
                        <div class="form-group">
<select name="ward" id="ward" class="form-input" required>
    <option value="">Phường/Xã</option>
</select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Lời nhắn</label>
                        <textarea name="note" class="form-textarea" 
                                  placeholder="Ghi chú thêm (Ví dụ: Giao hàng giờ hành chính)"></textarea>
                    </div>
                    
                    <div class="payment-section">
                        <h2 class="section-title">Phương thức thanh toán</h2>
                        
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="COD" checked>
                            <div class="payment-icon">💵</div>
                            <div class="payment-details">
                                <h4>Thanh toán khi nhận hàng (COD)</h4>
                                <p>Miễn phí vận chuyển cho mọi đơn hàng trên 500.000đ</p>
                            </div>
                        </label>
                        
                        <p class="payment-note">
                            Nếu bạn không hài lòng về sản phẩm của chúng tôi. Bạn hoàn toàn có thể trả lại sản phẩm. 
                            Tìm hiểu thêm <a href="#">Tại đây</a>
                        </p>
                    </div>

                    <button type="submit" class="btn-checkout">
                        ĐẶT HÀNG NGAY
                    </button>
                </form>
            </div>
            
<div class="order-summary">
    @foreach ($items as $item)
        <div class="product-item">
            <div class="product-info">

                <div class="product-image">
                    <img
                        src="{{ asset('uploads/product/' . $item['image']) }}"
                        alt="{{ $item['name'] }}"
                    >
                    <div class="product-quantity">{{ $item['quantity'] }}</div>
                </div>

                <div class="product-title">
                    {{ $item['name'] }}
                    ({{ $item['color'] }} - {{ $item['size'] }})
                </div>

                <div class="product-meta">
                    Số lượng: {{ $item['quantity'] }}
                </div>
            </div>

            <div class="product-price">
                {{ number_format($item['price'] * $item['quantity']) }}đ
            </div>
        </div>
    @endforeach
</div>





        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    // 1️⃣ Load Tỉnh/TP
    fetch('https://provinces.open-api.vn/api/p/')
        .then(res => res.json())
        .then(data => {
            data.forEach(province => {
                provinceSelect.innerHTML += `
                    <option value="${province.name}" data-code="${province.code}">
                        ${province.name}
                    </option>
                `;
            });
        });

    // 2️⃣ Khi chọn Tỉnh → load Quận/Huyện
    provinceSelect.addEventListener('change', function () {
        const provinceCode = this.selectedOptions[0].dataset.code;

        districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Phường/Xã</option>';

        if (!provinceCode) return;

        fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
            .then(res => res.json())
            .then(data => {
                data.districts.forEach(district => {
                    districtSelect.innerHTML += `
                        <option value="${district.name}" data-code="${district.code}">
                            ${district.name}
                        </option>
                    `;
                });
            });
    });

    // 3️⃣ Khi chọn Quận → load Phường/Xã
    districtSelect.addEventListener('change', function () {
        const districtCode = this.selectedOptions[0].dataset.code;

        wardSelect.innerHTML = '<option value="">Phường/Xã</option>';

        if (!districtCode) return;

        fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
            .then(res => res.json())
            .then(data => {
                data.wards.forEach(ward => {
                    wardSelect.innerHTML += `
                        <option value="${ward.name}">
                            ${ward.name}
                        </option>
                    `;
                });
            });
    });

});
</script>
@endpush

@endsection