@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
{{-- Import Animate.css từ CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* Background & Wrapper */
    .edit-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .edit-wrapper::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        top: -200px;
        right: -200px;
        animation: float 8s ease-in-out infinite;
    }

    .edit-wrapper::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -150px;
        left: -150px;
        animation: float 6s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Card */
    .edit-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(0,0,0,0.35);
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Header */
    .edit-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem 3rem;
        position: relative;
        overflow: hidden;
    }

    .edit-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .edit-card-header h5 {
        color: white;
        font-weight: 700;
        font-size: 2.2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 1;
        text-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .edit-card-header h5 i {
        font-size: 2.8rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Body */
    .edit-card-body {
        padding: 3rem;
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    }

    /* Section Headers */
    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 1.8rem;
        padding-bottom: 0.8rem;
        border-bottom: 3px solid #667eea;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        font-size: 1.6rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* Form Groups */
    .form-group-custom {
        margin-bottom: 2rem;
    }

    .label-custom {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.05rem;
    }

    .label-custom i {
        color: #667eea;
        font-size: 1.15rem;
    }

    .required-star {
        color: #e74c3c;
        margin-left: 0.25rem;
        font-weight: 700;
    }

    /* Inputs */
    .input-custom {
        border: 2px solid #e0e0e0;
        border-radius: 18px;
        padding: 1rem 1.5rem;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        background: #ffffff;
        width: 100%;
    }

    .input-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        transform: translateY(-3px);
        outline: none;
    }

    .input-custom:hover {
        border-color: #764ba2;
        background: #fcfcfc;
    }

    /* Select */
    .select-custom {
        border: 2px solid #e0e0e0;
        border-radius: 18px;
        padding: 1rem 1.5rem;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        background: #ffffff;
        cursor: pointer;
        width: 100%;
    }

    .select-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        transform: translateY(-3px);
        outline: none;
    }

    .select-custom:hover {
        border-color: #764ba2;
        background: #fcfcfc;
    }

    /* Upload Area */
    .upload-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 25px;
        padding: 2.5rem;
        border: 3px dashed #667eea;
        transition: all 0.4s ease;
        position: relative;
    }

    .upload-section:hover {
        border-color: #764ba2;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
    }

    .upload-box {
        width: 150px;
        height: 150px;
        border: 3px dashed #ccc;
        border-radius: 25px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .upload-box:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        transform: scale(1.1) rotate(-3deg);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
    }

    .upload-box:hover .plus-icon {
        color: white;
        transform: rotate(180deg) scale(1.2);
    }

    .upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 22px;
        transition: all 0.3s ease;
    }

    .upload-box:hover img {
        transform: scale(1.15);
        filter: brightness(0.9);
    }

    .upload-box .remove-btn {
        position: absolute;
        top: 8px;
        right: 10px;
        color: white;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        font-weight: bold;
        cursor: pointer;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(238, 90, 111, 0.6);
        z-index: 10;
        border: none;
        line-height: 1;
    }

    .upload-box .remove-btn:hover {
        transform: scale(1.3) rotate(90deg);
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        box-shadow: 0 6px 20px rgba(192, 57, 43, 0.8);
    }

    .upload-box.existing {
        border-color: #11998e;
        background: linear-gradient(135deg, #e0f7f4 0%, #d4f1ed 100%);
    }

    .upload-box.existing:hover {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-color: #11998e;
    }

    .plus-icon {
        font-size: 55px;
        color: #667eea;
        font-weight: 300;
        transition: all 0.4s ease;
    }

    /* Image Link Area */
    .image-link-area {
        display: flex;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: 18px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .image-link-area:hover {
        border-color: #667eea;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
    }

    .btn-add-link {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        padding: 0.8rem 1.8rem;
        border-radius: 15px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-add-link:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(17, 153, 142, 0.5);
    }

    /* Size Selection */
    .size-type-group {
        display: flex;
        gap: 1.2rem;
        margin-bottom: 1.8rem;
    }

    .size-type-group input[type="radio"] {
        display: none;
    }

    .size-type-label {
        padding: 1rem 2.5rem;
        border-radius: 50px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        background: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .size-type-group input:checked + .size-type-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: scale(1.08);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    .size-type-label:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    /* Size Items */
    .size-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 1.5rem;
        background: white;
        border-radius: 18px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .size-item:hover {
        border-color: #667eea;
        transform: translateY(-4px) rotate(1deg);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .size-item input[type="checkbox"]:checked ~ span {
        color: #667eea;
        font-weight: 700;
    }

    .size-item input[type="number"] {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 0.6rem;
        width: 85px;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .size-item input[type="number"]:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: scale(1.05);
        outline: none;
    }

    /* Price Grid */
    .price-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.8rem;
    }

    .price-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.8rem;
        border-radius: 25px;
        border: 2px solid transparent;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .price-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }

    .price-item:hover::before {
        left: 100%;
    }

    .price-item:hover {
        border-color: #667eea;
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
        background: white;
    }

    /* Textarea */
    .textarea-custom {
        border: 2px solid #e0e0e0;
        border-radius: 18px;
        padding: 1.2rem 1.5rem;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        background: #ffffff;
        resize: vertical;
        min-height: 140px;
        width: 100%;
    }

    .textarea-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        outline: none;
    }

    /* Radio Status */
    .status-group {
        display: flex;
        gap: 2rem;
    }

    .status-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 1rem 2rem;
        border-radius: 50px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .status-label:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .status-group input:checked + .status-label {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .status-group input[type="radio"] {
        display: none;
    }

    /* Buttons */
    .button-container {
        display: flex;
        gap: 1.5rem;
        margin-top: 3rem;
        justify-content: center;
    }

    .btn-update-custom {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        padding: 1.3rem 4rem;
        border-radius: 50px;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.4s ease;
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.4);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .btn-update-custom::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-update-custom:hover::before {
        width: 500px;
        height: 500px;
    }

    .btn-update-custom:hover {
        transform: translateY(-6px) scale(1.05);
        box-shadow: 0 18px 45px rgba(17, 153, 142, 0.6);
    }

    .btn-back-custom {
        background: white;
        border: 2px solid #667eea;
        padding: 1.3rem 4rem;
        border-radius: 50px;
        color: #667eea;
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.4s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back-custom:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-6px) scale(1.05);
        box-shadow: 0 18px 45px rgba(102, 126, 234, 0.4);
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-12px); }
        75% { transform: translateX(12px); }
    }

    .shake {
        animation: shake 0.5s;
    }
</style>

<div class="edit-wrapper">
    <div class="edit-card animate__animated animate__fadeInUp">
        <div class="edit-card-header">
            <h5 class="animate__animated animate__fadeInLeft">
                <i class="fas fa-edit"></i>
                Chỉnh sửa sản phẩm
            </h5>
        </div>

        <div class="edit-card-body">
            <form action="{{ route('admin.product.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- THÔNG TIN CƠ BẢN --}}
                <div class="section-title animate__animated animate__fadeInLeft">
                    <i class="fas fa-info-circle"></i>
                    Thông tin cơ bản
                </div>

                <div class="form-group-custom animate__animated animate__fadeInLeft animate__delay-1s">
                    <label class="label-custom">
                        <i class="fas fa-tag"></i>
                        Tên sản phẩm
                        <span class="required-star">*</span>
                    </label>
                    <input type="text" name="name_product" class="input-custom" 
                           value="{{ old('name_product', $product->name_product) }}" 
                           placeholder="Nhập tên sản phẩm..." required>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group-custom animate__animated animate__fadeInLeft animate__delay-1s">
                        <label class="label-custom">
                            <i class="fas fa-certificate"></i>
                            Hiệu sản phẩm
                        </label>
                        <select name="id_label" class="select-custom">
                            <option value="">-- Chọn hiệu --</option>
                            @foreach($labels as $label)
                                <option value="{{ $label->id_label }}" 
                                    {{ $product->id_label == $label->id_label ? 'selected' : '' }}>
                                    {{ $label->name_label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group-custom animate__animated animate__fadeInLeft animate__delay-1s">
                        <label class="label-custom">
                            <i class="fas fa-layer-group"></i>
                            Loại sản phẩm
                        </label>
                        <select name="id_category" class="select-custom">
                            <option value="">-- Chọn loại --</option>
                            @foreach($categories as $cate)
                                <option value="{{ $cate->id_category }}" 
                                    {{ $product->id_category == $cate->id_category ? 'selected' : '' }}>
                                    {{ $cate->name_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- HÌNH ẢNH --}}
                <div class="section-title mt-4 animate__animated animate__fadeInLeft">
                    <i class="fas fa-images"></i>
                    Hình ảnh sản phẩm
                </div>

                <div class="form-group-custom animate__animated animate__fadeInUp">
                    <div class="upload-section">
                        <div id="image-preview-wrapper" class="d-flex flex-wrap gap-3">
                            @foreach($product->images as $img)
                                <div class="upload-box existing animate__animated animate__zoomIn" data-id="{{ $img->id_image }}">
                                    <img src="{{ asset('uploads/product/'.$img->image_url) }}" alt="">
                                    <span class="remove-btn" data-id="{{ $img->id_image }}">&times;</span>
                                </div>
                            @endforeach

                            <div class="upload-box animate__animated animate__bounceIn" id="add-image-btn">
                                <span class="plus-icon">+</span>
                            </div>
                        </div>

                        <input type="file" id="image-input" name="images[]" multiple accept="image/*" style="display:none">
                        <input type="hidden" name="deleted_images" id="deleted_images">

                        <div class="image-link-area">
                            <input type="url" id="image-link" class="input-custom" 
                                   placeholder="🔗 Dán link ảnh tại đây...">
                            <button type="button" id="add-link-btn" class="btn-add-link">
                                <i class="fas fa-plus-circle me-2"></i>Thêm
                            </button>
                        </div>
                    </div>
                </div>

                @php
                    $sizeData = [];
                    if (!empty($product->size_product)) {
                        foreach (explode(',', $product->size_product) as $pair) {
                            [$s, $q] = explode(':', $pair) + [null, 0];
                            $sizeData[$s] = $q;
                        }
                    }
                @endphp



                {{-- GIÁ CẢ --}}
                <div class="section-title mt-4 animate__animated animate__fadeInLeft">
                    <i class="fas fa-dollar-sign"></i>
                    Giá cả
                </div>

                <div class="price-grid form-group-custom animate__animated animate__fadeInUp">
                    <div class="price-item">
                        <label class="label-custom">
                            <i class="fas fa-download"></i>
                            Giá nhập
                        </label>
                        <input type="number" name="import_price" class="input-custom" 
                               value="{{ old('import_price', $product->import_price) }}" 
                               min="0" placeholder="0 ₫">
                    </div>
                    <div class="price-item">
                        <label class="label-custom">
                            <i class="fas fa-money-bill-wave"></i>
                            Giá bán
                            <span class="required-star">*</span>
                        </label>
                        <input type="number" name="price_product" class="input-custom" 
                               value="{{ old('price_product', $product->price_product) }}" 
                               required min="0" placeholder="0 ₫">
                    </div>
                    <div class="price-item">
                        <label class="label-custom">
                            <i class="fas fa-tags"></i>
                            Giá khuyến mãi
                        </label>
                        <input type="number" name="saleprice_product" class="input-custom" 
                               value="{{ old('saleprice_product', $product->saleprice_product) }}" 
                               min="0" placeholder="0 ₫">
                    </div>
                </div>

                {{-- MÔ TẢ --}}
                <div class="section-title mt-4 animate__animated animate__fadeInLeft">
                    <i class="fas fa-align-left"></i>
                    Mô tả sản phẩm
                </div>

                <div class="form-group-custom animate__animated animate__fadeInUp">
                    <textarea name="describe_product" class="textarea-custom" 
                              placeholder="Nhập mô tả chi tiết về sản phẩm...">{{ old('describe_product', $product->describe_product) }}</textarea>
                </div>

                {{-- TRẠNG THÁI --}}
                <div class="section-title mt-4 animate__animated animate__fadeInLeft">
                    <i class="fas fa-toggle-on"></i>
                    Trạng thái
                </div>

                <div class="form-group-custom animate__animated animate__fadeInUp">
                    <div class="status-group">
                        <input type="radio" name="status_product" value="1" id="status-available"
                            {{ $product->status_product == '1' ? 'checked' : '' }}>
                        <label for="status-available" class="status-label">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>Còn hàng</span>
                        </label>
                        
                        <input type="radio" name="status_product" value="0" id="status-unavailable"
                            {{ $product->status_product == '0' ? 'checked' : '' }}>
                        <label for="status-unavailable" class="status-label">
                            <i class="fas fa-times-circle me-2"></i>
                            <span>Hết hàng</span>
                        </label>
                    </div>
                </div>
{{-- BIẾN THỂ SẢN PHẨM --}}
<div class="section-title mt-4 animate__animated animate__fadeInLeft">
    <i class="fas fa-boxes"></i>
    Biến thể sản phẩm
</div>

<div id="variant-wrapper" class="d-flex flex-column gap-2">

    {{-- BIẾN THỂ CŨ --}}
    @foreach($product->variants as $index => $variant)
        <div class="d-flex gap-2 variant-row">
            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id_variant }}">

            <input type="text" name="variants[{{ $index }}][sku]" class="form-control input-custom"
                value="{{ $variant->sku }}" placeholder="SKU" required>

            <input type="text" name="variants[{{ $index }}][size]" class="form-control input-custom"
                value="{{ $variant->size }}" placeholder="Size" required>

            <input type="text" name="variants[{{ $index }}][color]" class="form-control input-custom"
                value="{{ $variant->color }}" placeholder="Màu" required>

            <input type="number" name="variants[{{ $index }}][price]" class="form-control input-custom"
                value="{{ $variant->price }}" placeholder="Giá" required>

            <input type="number" name="variants[{{ $index }}][stock]" class="form-control input-custom"
                value="{{ $variant->stock }}" placeholder="Tồn kho" required>

            <button type="button" class="btn btn-danger remove-variant-old" data-id="{{ $variant->id_variant }}">
                X
            </button>
        </div>
    @endforeach

</div>

{{-- BIẾN THỂ MỚI --}}
<button type="button" id="add-variant" class="btn btn-secondary mt-3">
    + Thêm biến thể mới
</button>

{{-- INPUT ẨN ĐỂ XÓA --}}
<input type="hidden" name="deleted_variants" id="deleted_variants">

<script>
let variantIndex = {{ count($product->variants) }};

// Thêm biến thể mới
document.getElementById('add-variant').addEventListener('click', function() {
    const html = `
    <div class="d-flex gap-2 mt-2 variant-row">
        <input type="text" name="variants[${variantIndex}][sku]" class="form-control input-custom" placeholder="SKU" required>
        <input type="text" name="variants[${variantIndex}][size]" class="form-control input-custom" placeholder="Size" required>
        <input type="text" name="variants[${variantIndex}][color]" class="form-control input-custom" placeholder="Màu" required>
        <input type="number" name="variants[${variantIndex}][stock]" class="form-control input-custom" placeholder="Tồn kho" required>
        <button type="button" class="btn btn-danger remove-variant-new">X</button>
    </div>`;

    document.getElementById('variant-wrapper').insertAdjacentHTML('beforeend', html);
    variantIndex++;
});

// Xóa biến thể mới
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-variant-new')) {
        e.target.parentElement.remove();
    }
});

// Xóa biến thể cũ
let deleted = [];
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-variant-old')) {
        const id = e.target.dataset.id;
        deleted.push(id);
        document.getElementById('deleted_variants').value = deleted.join(',');
        e.target.parentElement.remove();
    }
});
</script>

                <div class="button-container animate__animated animate__fadeInUp">
                    <button type="submit" class="btn-update-custom">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                    <a href="{{ route('admin.product.index') }}" class="btn-back-custom">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // =================== SIZE TYPE TOGGLE ===================
    const sizeRadios = document.querySelectorAll('input[name="size_type"]');
    const sizeText = document.getElementById('size-text');
    const sizeNumber = document.getElementById('size-number');

    function updateSizeGroup() {
        const checked = document.querySelector('input[name="size_type"]:checked')?.value || 'text';
        if (checked === 'number') {
            sizeText.classList.add('d-none');
            sizeNumber.classList.remove('d-none');
        } else {
            sizeText.classList.remove('d-none');
            sizeNumber.classList.add('d-none');
        }
    }

    updateSizeGroup();
    sizeRadios.forEach(radio => radio.addEventListener('change', updateSizeGroup));

    // =================== IMAGE UPLOAD ===================
    const addBtn = document.getElementById('add-image-btn');
    const imageInput = document.getElementById('image-input');
    const wrapper = document.getElementById('image-preview-wrapper');
    const deletedInput = document.getElementById('deleted_images');
    const addLinkBtn = document.getElementById('add-link-btn');
    const imageLinkInput = document.getElementById('image-link');
    let fileList = [];
    let deleted = [];

    // Click nút + để upload ảnh
    addBtn?.addEventListener('click', () => imageInput?.click());

    // Khi chọn file mới
    imageInput?.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        fileList = [...fileList, ...files];
        renderNewImages();
    });

    // Render ảnh mới được upload
    function renderNewImages() {
        wrapper.querySelectorAll('.upload-box.new').forEach(box => box.remove());
        fileList.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const box = document.createElement('div');
                box.classList.add('upload-box', 'new', 'animate__animated', 'animate__zoomIn');
                box.innerHTML = `
                    <img src="${e.target.result}" alt="">
                    <span class="remove-btn" data-index="${index}" data-type="new">&times;</span>
                `;
                box.dataset.index = index;
                wrapper.insertBefore(box, addBtn);
            };
            reader.readAsDataURL(file);
        });
    }

    // Xử lý click vào wrapper (xóa ảnh hoặc thay thế ảnh existing)
    wrapper?.addEventListener('click', (e) => {
        // Xóa ảnh
        if (e.target.classList.contains('remove-btn')) {
            const type = e.target.dataset.type;
            
            if (type === 'new') {
                // Xóa ảnh mới vừa upload
                const idx = parseInt(e.target.dataset.index);
                fileList.splice(idx, 1);
                renderNewImages();
            } else {
                // Xóa ảnh cũ (đánh dấu để xóa trên server)
                const id = e.target.dataset.id;
                deleted.push(id);
                deletedInput.value = deleted.join(',');
                
                const box = e.target.parentElement;
                box.classList.add('animate__animated', 'animate__zoomOut');
                setTimeout(() => box.remove(), 500);
            }
            return;
        }

        // Click vào ảnh existing để thay thế
        const box = e.target.closest('.upload-box');
        if (box && box.classList.contains('existing') && !e.target.classList.contains('remove-btn')) {
            const tempInput = document.createElement('input');
            tempInput.type = 'file';
            tempInput.accept = 'image/*';
            tempInput.click();

            tempInput.onchange = (ev) => {
                const newFile = ev.target.files[0];
                if (newFile) {
                    const reader = new FileReader();
                    reader.onload = ev2 => {
                        const img = box.querySelector('img');
                        img.classList.add('animate__animated', 'animate__rotateIn');
                        img.src = ev2.target.result;
                        box.classList.add('replaced');
                        box.dataset.newfile = newFile;
                    };
                    reader.readAsDataURL(newFile);
                }
            };
        }
    });

    // Thêm ảnh từ link
    addLinkBtn?.addEventListener('click', () => {
        const url = imageLinkInput.value.trim();
        if (!url) {
            imageLinkInput.classList.add('shake');
            setTimeout(() => imageLinkInput.classList.remove('shake'), 500);
            return;
        }
        
        const box = document.createElement('div');
        box.classList.add('upload-box', 'animate__animated', 'animate__bounceIn');
        box.innerHTML = `
            <img src="${url}" alt="" onerror="this.parentElement.style.border='3px dashed #e74c3c'">
            <span class="remove-btn" data-type="link">&times;</span>
            <input type="hidden" name="image_links[]" value="${url}">
        `;
        
        // Thêm event listener cho nút xóa của ảnh link
        const removeBtn = box.querySelector('.remove-btn');
        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            box.classList.add('animate__animated', 'animate__zoomOut');
            setTimeout(() => box.remove(), 500);
        });
        
        wrapper.insertBefore(box, addBtn);
        imageLinkInput.value = '';
    });

    // =================== FORM VALIDATION ===================
    const form = document.querySelector('form');
    form?.addEventListener('submit', function(e) {
        const requiredInputs = this.querySelectorAll('[required]');
        let hasError = false;
        
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                hasError = true;
                input.classList.add('shake', 'animate__animated', 'animate__shakeX');
                input.style.borderColor = '#e74c3c';
                
                setTimeout(() => {
                    input.classList.remove('shake', 'animate__animated', 'animate__shakeX');
                    input.style.borderColor = '';
                }, 1000);
            }
        });
        
        if (hasError) {
            e.preventDefault();
            
            // Scroll đến input lỗi đầu tiên
            const firstError = this.querySelector('.shake');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    // =================== RIPPLE EFFECT ON BUTTON ===================
    const submitBtn = document.querySelector('.btn-update-custom');
    submitBtn?.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            border-radius: 50%;
            background: rgba(255,255,255,0.6);
            left: ${x}px;
            top: ${y}px;
            pointer-events: none;
            animation: ripple-animation 0.8s ease-out;
        `;
        
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 800);
    });

    // Add ripple animation
    const rippleStyle = document.createElement('style');
    rippleStyle.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(rippleStyle);

    // =================== AUTO FOCUS WITH ANIMATION ===================
    setTimeout(() => {
        const firstInput = document.querySelector('input[name="name_product"]');
        if (firstInput) {
            firstInput.focus();
            firstInput.classList.add('animate__animated', 'animate__pulse');
        }
    }, 500);

    // =================== HOVER EFFECTS ON INPUTS ===================
    const allInputs = document.querySelectorAll('.input-custom, .select-custom, .textarea-custom');
    allInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // =================== SIZE BOX INTERACTION ===================
    const sizeBoxes = document.querySelectorAll('.size-item');
    sizeBoxes.forEach(box => {
        const checkbox = box.querySelector('input[type="checkbox"]');
        const quantityInput = box.querySelector('input[type="number"]');
        
        // Khi check/uncheck, focus vào input số lượng
        checkbox?.addEventListener('change', function() {
            if (this.checked) {
                quantityInput?.focus();
                box.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    box.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            }
        });
        
        // Click vào box cũng check checkbox
        box.addEventListener('click', function(e) {
            if (e.target !== checkbox && e.target !== quantityInput) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    });

    // =================== PRICE INPUT FORMATTING ===================
    const priceInputs = document.querySelectorAll('input[name="import_price"], input[name="price_product"], input[name="saleprice_product"]');
    priceInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.parentElement.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        });
    });

    // =================== SMOOTH SCROLL FOR SECTIONS ===================
    const sections = document.querySelectorAll('.section-title');
    sections.forEach(section => {
        section.style.cursor = 'pointer';
        section.addEventListener('click', function() {
            this.scrollIntoView({ behavior: 'smooth', block: 'start' });
            this.classList.add('animate__animated', 'animate__headShake');
            setTimeout(() => {
                this.classList.remove('animate__animated', 'animate__headShake');
            }, 1000);
        });
    });

    // =================== IMAGE PREVIEW MAGNIFIER ===================
    const images = wrapper.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('mouseenter', function() {
            if (!this.parentElement.classList.contains('upload-box')) return;
            this.style.transform = 'scale(1.15)';
            this.style.zIndex = '100';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.zIndex = '1';
        });
    });

    // =================== TEXTAREA AUTO RESIZE ===================
    const textarea = document.querySelector('.textarea-custom');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Trigger resize on load
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    // =================== SUCCESS MESSAGE ANIMATION ===================
    // Nếu có thông báo thành công sau khi submit
    const successMessage = document.querySelector('.alert-success');
    if (successMessage) {
        successMessage.classList.add('animate__animated', 'animate__bounceIn');
        setTimeout(() => {
            successMessage.classList.add('animate__fadeOut');
            setTimeout(() => successMessage.remove(), 1000);
        }, 5000);
    }

    // =================== LOADING STATE ON SUBMIT ===================
    form?.addEventListener('submit', function() {
        const submitButton = this.querySelector('.btn-update-custom');
        if (submitButton && !this.querySelector('.shake')) {
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
            submitButton.disabled = true;
        }
    });
});
</script>

@endsection