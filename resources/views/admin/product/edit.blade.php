@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        margin: 5px;
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

                {{-- HÌNH ẢNH SẢN PHẨM --}}
                <div class="section-title mt-4 animate__animated animate__fadeInLeft">
                    <i class="fas fa-images"></i>
                    Hình ảnh sản phẩm
                </div>

                <div class="form-group-custom animate__animated animate__fadeInUp">
                    <div class="upload-section">
                        <div id="image-preview-wrapper">
                            {{-- Hiển thị ảnh cũ --}}
                            @if($product->images && count($product->images) > 0)
                                @foreach($product->images as $img)
                                    <div class="upload-box existing animate__animated animate__zoomIn" data-type="old">
                                        <img src="{{ asset('uploads/product/'.$img->image_url) }}" alt="">
                                        <button type="button" class="remove-btn" data-type="old" data-id="{{ $img->id_image }}">&times;</button>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Nút thêm ảnh --}}
                            <div class="upload-box animate__animated animate__bounceIn" id="add-image-btn">
                                <span class="plus-icon">+</span>
                            </div>
                        </div>

                        <input type="file" id="image-input" name="images[]" multiple accept="image/*" style="display:none">
                        <input type="hidden" name="deleted_images" id="deleted-images-input">
                    </div>
                </div>

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
                    {{-- Biến thể cũ --}}
                    @foreach($product->variants as $index => $variant)
                        <div class="d-flex gap-2 variant-row">
                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id_variant }}">
                            <input type="text" name="variants[{{ $index }}][sku]" class="form-control input-custom"
                                   value="{{ $variant->sku }}" placeholder="SKU" required>
                            <input type="text" name="variants[{{ $index }}][size]" class="form-control input-custom"
                                   value="{{ $variant->size }}" placeholder="Size" required>
                            <input type="text" name="variants[{{ $index }}][color]" class="form-control input-custom"
                                   value="{{ $variant->color }}" placeholder="Màu" required>
                            <input type="number" name="variants[{{ $index }}][stock]" class="form-control input-custom"
                                   value="{{ $variant->stock }}" placeholder="Tồn kho" required>
                            <button type="button" class="btn btn-danger remove-variant-old" data-id="{{ $variant->id_variant }}">X</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-variant" class="btn btn-secondary mt-3">
                    + Thêm biến thể mới
                </button>

                <input type="hidden" name="deleted_variants" id="deleted-variants-input">

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
    
    // ========== QUẢN LÝ HÌNH ẢNH ==========
    const addImageBtn = document.getElementById('add-image-btn');
    const imageInput = document.getElementById('image-input');
    const imageWrapper = document.getElementById('image-preview-wrapper');
    const deletedImagesInput = document.getElementById('deleted-images-input');
    
    let newImageFiles = [];
    let deletedImageIds = [];

    // Click nút + để chọn file
    if (addImageBtn) {
        addImageBtn.addEventListener('click', function() {
            imageInput.click();
        });
    }

    // Khi chọn file mới
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            files.forEach(file => {
                newImageFiles.push(file);
                
                // Hiển thị preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const box = document.createElement('div');
                    box.className = 'upload-box animate__animated animate__zoomIn';
                    box.setAttribute('data-type', 'new');
                    box.innerHTML = `
                        <img src="${e.target.result}" alt="">
                        <button type="button" class="remove-btn" data-type="new" data-index="${newImageFiles.length - 1}">&times;</button>
                    `;
                    imageWrapper.insertBefore(box, addImageBtn);
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // Xóa ảnh
    imageWrapper.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-btn')) {
            const type = e.target.getAttribute('data-type');
            const parent = e.target.closest('.upload-box');
            
            if (type === 'old') {
                // Xóa ảnh cũ - lưu ID vào input hidden
                const id = e.target.getAttribute('data-id');
                deletedImageIds.push(id);
                deletedImagesInput.value = deletedImageIds.join(',');
                parent.remove();
            } 
            else if (type === 'new') {
                // Xóa ảnh mới - remove khỏi array
                const index = parseInt(e.target.getAttribute('data-index'));
                newImageFiles.splice(index, 1);
                parent.remove();
                
                // Cập nhật lại input file
                updateFileInput();
            }
        }
    });

    // Cập nhật input file với array mới
    function updateFileInput() {
        const dt = new DataTransfer();
        newImageFiles.forEach(file => {
            dt.items.add(file);
        });
        imageInput.files = dt.files;
    }

    // ========== QUẢN LÝ BIẾN THỂ ==========
    let variantIndex = {{ count($product->variants) }};
    const addVariantBtn = document.getElementById('add-variant');
    const variantWrapper = document.getElementById('variant-wrapper');
    const deletedVariantsInput = document.getElementById('deleted-variants-input');
    
    let deletedVariantIds = [];

    // Thêm biến thể mới
    if (addVariantBtn) {
        addVariantBtn.addEventListener('click', function() {
            const html = `
                <div class="d-flex gap-2 mt-2 variant-row">
                    <input type="text" name="variants[${variantIndex}][sku]" class="form-control input-custom" placeholder="SKU" required>
                    <input type="text" name="variants[${variantIndex}][size]" class="form-control input-custom" placeholder="Size" required>
                    <input type="text" name="variants[${variantIndex}][color]" class="form-control input-custom" placeholder="Màu" required>
                    <input type="number" name="variants[${variantIndex}][stock]" class="form-control input-custom" placeholder="Tồn kho" required>
                    <button type="button" class="btn btn-danger remove-variant-new">X</button>
                </div>
            `;
            variantWrapper.insertAdjacentHTML('beforeend', html);
            variantIndex++;
        });
    }

    // Xóa biến thể
    document.addEventListener('click', function(e) {
        // Xóa biến thể mới
        if (e.target.classList.contains('remove-variant-new')) {
            e.target.closest('.variant-row').remove();
        }
        
        // Xóa biến thể cũ
        if (e.target.classList.contains('remove-variant-old')) {
            const id = e.target.getAttribute('data-id');
            deletedVariantIds.push(id);
            deletedVariantsInput.value = deletedVariantIds.join(',');
            e.target.closest('.variant-row').remove();
        }
    });
});
</script>

@endsection