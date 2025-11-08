@extends('admin.layouts.master')
@section('title', 'Thêm mới sản phẩm')

@section('content')
<style>
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

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-15px);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            opacity: 1;
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            transform: scale(1);
        }
    }

    .product-create-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem;
        animation: fadeInUp 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .product-create-wrapper::before {
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

    .product-create-wrapper::after {
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

    .product-card {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        max-width: 1200px;
        margin: 0 auto;
        animation: fadeInUp 0.8s ease-out;
        position: relative;
        z-index: 1;
    }

    .product-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .product-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 3s infinite;
    }

    .product-header h5 {
        color: white;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 1;
        animation: slideInLeft 0.8s ease-out;
    }

    .product-header h5 i {
        font-size: 2.5rem;
        animation: pulse 2s ease-in-out infinite;
    }

    .product-form-container {
        padding: 3rem 2.5rem;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #667eea;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideInLeft 0.6s ease-out;
    }

    .section-title i {
        font-size: 1.5rem;
    }

    .form-group-animated {
        margin-bottom: 2rem;
        animation: slideInLeft 0.6s ease-out;
        animation-fill-mode: both;
    }

    .form-group-animated:nth-child(1) { animation-delay: 0.1s; }
    .form-group-animated:nth-child(2) { animation-delay: 0.15s; }
    .form-group-animated:nth-child(3) { animation-delay: 0.2s; }
    .form-group-animated:nth-child(4) { animation-delay: 0.25s; }
    .form-group-animated:nth-child(5) { animation-delay: 0.3s; }

    .label-custom {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .label-custom i {
        color: #667eea;
        font-size: 1.1rem;
    }

    .required-mark {
        color: #e74c3c;
        margin-left: 0.25rem;
    }

    .input-custom {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 0.9rem 1.3rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .input-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        transform: translateY(-2px);
    }

    .input-custom:hover {
        border-color: #764ba2;
        background: white;
    }

    .select-custom {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 0.9rem 1.3rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
        cursor: pointer;
    }

    .select-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        transform: translateY(-2px);
    }

    .select-custom:hover {
        border-color: #764ba2;
        background: white;
    }

    /* Upload Image Styles */
    .upload-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 20px;
        padding: 2rem;
        border: 2px dashed #667eea;
        transition: all 0.3s ease;
    }

    .upload-section:hover {
        border-color: #764ba2;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }

    .upload-box {
        width: 140px;
        height: 140px;
        border: 3px dashed #ccc;
        border-radius: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: bounceIn 0.6s ease-out;
    }

    .upload-box:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        transform: scale(1.05) rotate(2deg);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .upload-box:hover .plus-icon {
        color: white;
        transform: rotate(180deg);
    }

    .upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 17px;
    }

    .upload-box .remove-btn {
        position: absolute;
        top: 5px;
        right: 8px;
        color: white;
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        font-weight: bold;
        cursor: pointer;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(250, 112, 154, 0.5);
    }

    .upload-box .remove-btn:hover {
        transform: scale(1.2) rotate(90deg);
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .plus-icon {
        font-size: 50px;
        color: #667eea;
        font-weight: 300;
        transition: all 0.3s ease;
    }

    /* Size Selection */
    .size-type-selector {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .size-type-selector label {
        padding: 0.75rem 2rem;
        border-radius: 50px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        background: white;
    }

    .size-type-selector input:checked + label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .size-type-selector label:hover {
        border-color: #667eea;
        transform: translateY(-2px);
    }

    .size-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: white;
        border-radius: 15px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .size-item:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    .size-item input[type="checkbox"]:checked ~ label {
        color: #667eea;
        font-weight: 700;
    }

    .size-item input[type="number"] {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 0.5rem;
        width: 80px;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .size-item input[type="number"]:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Price Section */
    .price-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .price-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-radius: 20px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .price-item:hover {
        border-color: #667eea;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        background: white;
    }

    /* Radio Buttons */
    .radio-group {
        display: flex;
        gap: 2rem;
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .radio-item:hover {
        border-color: #667eea;
        transform: translateY(-2px);
    }

    .radio-item input:checked ~ span {
        color: #667eea;
        font-weight: 700;
    }

    .radio-item input[type="radio"]:checked {
        accent-color: #667eea;
    }

    /* Textarea */
    .textarea-custom {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 1rem 1.3rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
        resize: vertical;
        min-height: 120px;
    }

    .textarea-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
    }

    /* Submit Button */
    .btn-submit-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1.2rem 4rem;
        border-radius: 50px;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .btn-submit-custom::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-submit-custom:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-submit-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
    }

    .btn-submit-custom:active {
        transform: translateY(-2px);
    }

    /* Alert */
    .alert-custom {
        border-radius: 15px;
        padding: 1.5rem;
        border: none;
        animation: bounceIn 0.6s ease-out;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .image-link-group {
        display: flex;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: 15px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .image-link-group:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    .btn-add-link {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-add-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(17, 153, 142, 0.4);
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .shake {
        animation: shake 0.5s;
    }
</style>

<div class="product-create-wrapper">
    <div class="product-card">
        <div class="product-header">
            <h5>
                <i class="fas fa-box-open"></i>
                Thêm mới sản phẩm
            </h5>
        </div>

        <div class="product-form-container">
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- THÔNG TIN CƠ BẢN --}}
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Thông tin cơ bản
                </div>

                <div class="form-group-animated">
                    <label class="label-custom">
                        <i class="fas fa-tag"></i>
                        Tên sản phẩm
                        <span class="required-mark">*</span>
                    </label>
                    <input type="text" name="name_product" class="form-control input-custom" 
                           placeholder="Nhập tên sản phẩm..." required>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group-animated">
                        <label class="label-custom">
                            <i class="fas fa-certificate"></i>
                            Hiệu sản phẩm
                            <span class="required-mark">*</span>
                        </label>
                        <select name="id_label" class="form-select select-custom" required>
                            <option value="">-- Chọn hiệu --</option>
                            @foreach($labels as $label)
                                <option value="{{ $label->id_label }}">{{ $label->name_label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group-animated">
                        <label class="label-custom">
                            <i class="fas fa-layer-group"></i>
                            Thuộc loại
                            <span class="required-mark">*</span>
                        </label>
                        <select name="id_category" class="form-select select-custom" required>
                            <option value="">-- Chọn loại sản phẩm --</option>
                            @foreach($categories as $cate)
                                <option value="{{ $cate->id_category }}">{{ $cate->name_category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- HÌNH ẢNH --}}
                <div class="section-title mt-4">
                    <i class="fas fa-images"></i>
                    Hình ảnh sản phẩm
                </div>

                <div class="form-group-animated">
                    <div class="upload-section">
                        <div id="image-preview-wrapper" class="d-flex flex-wrap gap-3">
                            <div class="upload-box" id="add-image-btn">
                                <span class="plus-icon">+</span>
                            </div>
                        </div>
                        <input type="file" id="image-input" name="images[]" multiple accept="image/*" style="display:none">

                        <div class="image-link-group mt-3">
                            <input type="url" id="image-link" class="form-control input-custom" 
                                   placeholder="🔗 Dán link ảnh tại đây...">
                            <button type="button" id="add-link-btn" class="btn btn-add-link">
                                <i class="fas fa-plus-circle me-2"></i>Thêm
                            </button>
                        </div>
                    </div>
                </div>

                {{-- SIZE & SỐ LƯỢNG --}}
                <div class="section-title mt-4">
                    <i class="fas fa-ruler"></i>
                    Size & Số lượng
                </div>

                <div class="form-group-animated">
                    <div class="size-type-selector">
                        <input type="radio" name="size_type" value="char" id="size-char" checked hidden>
                        <label for="size-char">
                            <i class="fas fa-font me-2"></i>Size chữ (S, M, L, XL...)
                        </label>
                        
                        <input type="radio" name="size_type" value="num" id="size-num" hidden>
                        <label for="size-num">
                            <i class="fas fa-calculator me-2"></i>Size số (27, 28, 29...)
                        </label>
                    </div>

                    {{-- SIZE CHỮ --}}
                    <div id="size-text" class="d-flex flex-wrap gap-3">
                        @foreach(['S','M','L','XL','XXL','XXXL'] as $size)
                            <div class="size-item">
                                <input type="checkbox" name="sizes[]" value="{{ $size }}" id="size_{{ $size }}">
                                <label for="size_{{ $size }}" class="mb-0 fw-bold">{{ $size }}</label>
                                <input type="number" name="quantities[{{ $size }}]" value="0" 
                                       class="form-control" min="0">
                            </div>
                        @endforeach
                    </div>

                    {{-- SIZE SỐ --}}
                    <div id="size-number" class="d-flex flex-wrap gap-3 d-none">
                        @for($i = 27; $i <= 44; $i++)
                            <div class="size-item">
                                <input type="checkbox" name="sizes[]" value="{{ $i }}" id="size_{{ $i }}">
                                <label for="size_{{ $i }}" class="mb-0 fw-bold">{{ $i }}</label>
                                <input type="number" name="quantities[{{ $i }}]" value="0" 
                                       class="form-control" min="0">
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- GIÁ CẢ --}}
                <div class="section-title mt-4">
                    <i class="fas fa-dollar-sign"></i>
                    Giá cả
                </div>

                <div class="price-grid form-group-animated">
                    <div class="price-item">
                        <label class="label-custom">
                            <i class="fas fa-download"></i>
                            Giá nhập
                        </label>
                        <input type="number" name="import_price" class="form-control input-custom" 
                               value="0" min="0" placeholder="0 ₫">
                    </div>
                    <div class="price-item">
                        <label class="label-custom">
                            <i class="fas fa-money-bill-wave"></i>
                            Giá bán
                            <span class="required-mark">*</span>
                        </label>
                        <input type="number" name="price_product" class="form-control input-custom" 
                               required min="0" placeholder="0 ₫">
                    </div>
                    <div class="price-item">
                        <label class="label-custom">
                            <i class="fas fa-tags"></i>
                            Giá khuyến mãi
                        </label>
                        <input type="number" name="saleprice_product" class="form-control input-custom" 
                               min="0" placeholder="0 ₫">
                    </div>
                </div>

                {{-- MÔ TẢ --}}
                <div class="section-title mt-4">
                    <i class="fas fa-align-left"></i>
                    Mô tả sản phẩm
                </div>

                <div class="form-group-animated">
                    <textarea name="describe_product" class="form-control textarea-custom" 
                              placeholder="Nhập mô tả chi tiết về sản phẩm..."></textarea>
                </div>

                {{-- TRẠNG THÁI --}}
                <div class="section-title mt-4">
                    <i class="fas fa-toggle-on"></i>
                    Trạng thái
                </div>

                <div class="form-group-animated">
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="status_product" value="1" checked>
                            <span><i class="fas fa-check-circle me-2"></i>Còn hàng</span>
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="status_product" value="0">
                            <span><i class="fas fa-times-circle me-2"></i>Hết hàng</span>
                        </label>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-submit-custom">
                        <i class="fas fa-save me-2"></i>Thêm sản phẩm
                    </button>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-custom mt-4">
                        <h6 class="mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
const addBtn = document.getElementById('add-image-btn');
const imageInput = document.getElementById('image-input');
const wrapper = document.getElementById('image-preview-wrapper');
let fileList = [];

addBtn.addEventListener('click', () => imageInput.click());

imageInput.addEventListener('change', (e) => {
    const files = Array.from(e.target.files);
    fileList = [...fileList, ...files];
    renderPreview();
});

// Size type toggle
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="size_type"]');
    const sizeText = document.getElementById('size-text');
    const sizeNumber = document.getElementById('size-number');

    function updateSizeGroup() {
        const checked = document.querySelector('input[name="size_type"]:checked')?.value || 'char';
        if (checked === 'num') {
            sizeText.classList.add('d-none');
            sizeNumber.classList.remove('d-none');
        } else {
            sizeText.classList.remove('d-none');
            sizeNumber.classList.add('d-none');
        }
    }

    updateSizeGroup();
    radios.forEach(radio => radio.addEventListener('change', updateSizeGroup));
});

function renderPreview() {
    wrapper.innerHTML = '';
    fileList.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const box = document.createElement('div');
            box.classList.add('upload-box');
            box.innerHTML = `
                <img src="${e.target.result}" alt="">
                <span class="remove-btn" data-index="${index}">&times;</span>
            `;
            box.dataset.index = index;
            wrapper.appendChild(box);
        };
        reader.readAsDataURL(file);
    });
    wrapper.appendChild(addBtn);
}

wrapper.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-btn')) {
        const index = parseInt(e.target.dataset.index);
        fileList.splice(index, 1);
        updateInputFiles();
        renderPreview();
        return;
    }

    const box = e.target.closest('.upload-box');
    if (box && !e.target.classList.contains('remove-btn') && !box.id) {
        const index = parseInt(box.dataset.index);
        const tempInput = document.createElement('input');
        tempInput.type = 'file';
        tempInput.accept = 'image/*';
        tempInput.click();

        tempInput.onchange = function (ev) {
            const newFile = ev.target.files[0];
            if (newFile) {
                fileList[index] = newFile;
                updateInputFiles();
                renderPreview();
            }
        };
    }
});

function updateInputFiles() {
    const dt = new DataTransfer();
    fileList.forEach(f => dt.items.add(f));
    imageInput.files = dt.files;
}

// Thêm ảnh từ link
const addLinkBtn = document.getElementById('add-link-btn');
const imageLinkInput = document.getElementById('image-link');

addLinkBtn.addEventListener('click', () => {
    const url = imageLinkInput.value.trim();
    if (!url) {
        imageLinkInput.classList.add('shake');
        setTimeout(() => imageLinkInput.classList.remove('shake'), 500);
        return;
    }
    
    const box = document.createElement('div');
    box.classList.add('upload-box');
    box.style.animationDelay = '0s';
    box.innerHTML = `
        <img src="${url}" alt="" onerror="this.parentElement.style.border='3px dashed #e74c3c'">
        <span class="remove-btn" data-type="link">&times;</span>
        <input type="hidden" name="image_links[]" value="${url}">
    `;
    
    // Remove click listener for link images
    box.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-btn')) {
            box.remove();
        }
    });
    
    wrapper.insertBefore(box, addBtn);
    imageLinkInput.value = '';
    
    // Add success animation
    box.style.animation = 'bounceIn 0.6s ease-out';
});

// Form validation with shake animation
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredInputs = this.querySelectorAll('[required]');
    let hasError = false;
    
    requiredInputs.forEach(input => {
        if (!input.value.trim()) {
            hasError = true;
            input.classList.add('shake');
            input.style.borderColor = '#e74c3c';
            setTimeout(() => {
                input.classList.remove('shake');
                input.style.borderColor = '';
            }, 500);
        }
    });
    
    if (hasError) {
        e.preventDefault();
    }
});

// Add ripple effect to submit button
document.querySelector('.btn-submit-custom').addEventListener('click', function(e) {
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
        background: rgba(255,255,255,0.5);
        left: ${x}px;
        top: ${y}px;
        pointer-events: none;
        animation: ripple-effect 0.8s ease-out;
    `;
    
    this.appendChild(ripple);
    setTimeout(() => ripple.remove(), 800);
});

// Add ripple effect animation
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    @keyframes ripple-effect {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyle);

// Auto-focus first input with animation
setTimeout(() => {
    const firstInput = document.querySelector('input[name="name_product"]');
    if (firstInput) {
        firstInput.focus();
        firstInput.style.animation = 'pulse 1s ease-out';
    }
}, 500);
</script>
@endsection