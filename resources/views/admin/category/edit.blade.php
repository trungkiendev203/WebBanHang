@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa loại sản phẩm')

@section('content')
<style>
    .premium-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .premium-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(102, 126, 234, 0.1);
        overflow: hidden;
        animation: slideInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .premium-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 32px 40px;
        position: relative;
        overflow: hidden;
    }

    .premium-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .header-text h5 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 24px;
        letter-spacing: -0.5px;
    }

    .header-text p {
        color: rgba(255, 255, 255, 0.9);
        margin: 4px 0 0 0;
        font-size: 14px;
    }

    .premium-body {
        padding: 48px 40px;
        background: white;
    }

    .form-section {
        margin-bottom: 32px;
        animation: fadeIn 0.8s ease-out;
        animation-fill-mode: both;
    }

    .form-section:nth-child(1) {
        animation-delay: 0.1s;
    }

    .form-section:nth-child(2) {
        animation-delay: 0.2s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .label-premium {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
        font-size: 15px;
        letter-spacing: -0.2px;
    }

    .label-icon {
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .input-premium {
        width: 100%;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        font-size: 16px;
        color: #334155;
        background: #f8fafc;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
    }

    .input-premium:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 8px 16px rgba(102, 126, 234, 0.08);
        transform: translateY(-2px);
    }

    .input-premium:hover:not(:focus) {
        border-color: #cbd5e0;
        background: white;
    }

    .input-wrapper-premium {
        position: relative;
    }

    .char-counter {
        position: absolute;
        right: 20px;
        bottom: 16px;
        font-size: 13px;
        color: #94a3b8;
        font-weight: 600;
        background: white;
        padding: 2px 8px;
        border-radius: 6px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .char-counter.warning {
        color: #f59e0b;
        animation: bounce 0.5s;
    }

    .char-counter.danger {
        color: #ef4444;
        animation: shake 0.5s;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }

    .select-premium {
        width: 100%;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 50px 16px 20px;
        font-size: 16px;
        color: #334155;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        appearance: none;
        font-weight: 600;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 22px;
    }

    .select-premium:focus {
        outline: none;
        border-color: #667eea;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 8px 16px rgba(102, 126, 234, 0.08);
        transform: translateY(-2px);
    }

    .select-premium:hover:not(:focus) {
        border-color: #cbd5e0;
        background-color: white;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        margin-top: 12px;
        animation: statusPop 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes statusPop {
        0% { transform: scale(0); }
        100% { transform: scale(1); }
    }

    .status-indicator.active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 2px solid #6ee7b7;
    }

    .status-indicator.inactive {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border: 2px solid #fca5a5;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    .status-indicator.active .status-dot {
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
    }

    .status-indicator.inactive .status-dot {
        background: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3);
    }

    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.8; }
    }

    .help-text-premium {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        margin-top: 10px;
        padding: 10px 14px;
        background: #f1f5f9;
        border-radius: 10px;
        border-left: 3px solid #667eea;
    }

    .help-icon {
        font-size: 16px;
    }

    .action-buttons {
        display: flex;
        gap: 16px;
        margin-top: 48px;
        padding-top: 32px;
        border-top: 2px dashed #e2e8f0;
        animation: fadeIn 1s ease-out 0.3s both;
    }

    .btn-premium {
        flex: 1;
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        letter-spacing: -0.3px;
    }

    .btn-premium-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        position: relative;
        overflow: hidden;
    }

    .btn-premium-primary::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn-premium-primary:hover::before {
        left: 100%;
    }

    .btn-premium-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
    }

    .btn-premium-primary:active {
        transform: translateY(-1px);
    }

    .btn-premium-secondary {
        background: white;
        color: #475569;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 2px solid #e2e8f0;
    }

    .btn-premium-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e0;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .btn-premium-secondary:active {
        transform: translateY(-1px);
    }

    .btn-icon {
        font-size: 20px;
        transition: transform 0.3s ease;
    }

    .btn-premium:hover .btn-icon {
        transform: scale(1.2);
    }

    @media (max-width: 768px) {
        .premium-header {
            padding: 24px 24px;
        }

        .premium-body {
            padding: 32px 24px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .header-text h5 {
            font-size: 20px;
        }
    }

    /* Loading animation cho submit */
    .btn-premium-primary.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .btn-premium-primary.loading .btn-icon {
        animation: rotate 1s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="premium-container">
    <div class="premium-card">
        <div class="premium-header">
            <div class="header-content">
                <div class="header-icon">📦</div>
                <div class="header-text">
                    <h5>Chỉnh sửa loại sản phẩm</h5>
                    <p>Cập nhật thông tin danh mục sản phẩm</p>
                </div>
            </div>
        </div>

        <div class="premium-body">
            <form action="{{ route('admin.category.update', $category->id_category) }}" method="POST" id="categoryForm">
                @csrf 
                @method('PUT')

                <div class="form-section">
                    <label class="label-premium">
                        <span class="label-icon">📝</span>
                        <span>Tên loại sản phẩm</span>
                    </label>
                    <div class="input-wrapper-premium">
                        <input 
                            type="text" 
                            name="name_category" 
                            class="input-premium" 
                            value="{{ $category->name_category }}" 
                            placeholder="Ví dụ: Điện thoại, Laptop, Phụ kiện..."
                            maxlength="100"
                            oninput="updateCharCounter(this)"
                            required
                        >
                        <span class="char-counter" id="charCounter">
                            <span id="currentCount">{{ strlen($category->name_category) }}</span>/100
                        </span>
                    </div>
                    <div class="help-text-premium">
                        <span class="help-icon">💡</span>
                        <span>Tên loại sản phẩm sẽ được hiển thị trên trang chủ và trong menu danh mục</span>
                    </div>
                </div>

                <div class="form-section">
                    <label class="label-premium">
                        <span class="label-icon">🔄</span>
                        <span>Trạng thái hiển thị</span>
                    </label>
                    <select name="status_category" class="select-premium" onchange="updateStatusIndicator(this)">
                        <option value="1" {{ $category->status_category == '1' ? 'selected' : '' }}>✅ Hiển thị công khai</option>
                        <option value="0" {{ $category->status_category == '0' ? 'selected' : '' }}>🔒 Ẩn khỏi website</option>
                    </select>
                    <div class="status-indicator {{ $category->status_category == '1' ? 'active' : 'inactive' }}" id="statusIndicator">
                        <span class="status-dot"></span>
                        <span id="statusText">{{ $category->status_category == '1' ? 'Đang hiển thị công khai' : 'Đang ẩn khỏi website' }}</span>
                    </div>
                    <div class="help-text-premium">
                        <span class="help-icon">ℹ️</span>
                        <span>Chọn trạng thái để kiểm soát việc hiển thị danh mục này trên website</span>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn-premium btn-premium-primary">
                        <span class="btn-icon">💾</span>
                        <span>Lưu thay đổi</span>
                    </button>
                    <a href="{{ route('admin.category.index') }}" class="btn-premium btn-premium-secondary">
                        <span class="btn-icon">←</span>
                        <span>Quay lại danh sách</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateCharCounter(input) {
    const counter = document.getElementById('charCounter');
    const currentCount = document.getElementById('currentCount');
    const length = input.value.length;
    
    currentCount.textContent = length;
    
    // Remove all classes first
    counter.classList.remove('warning', 'danger');
    
    // Add appropriate class based on length
    if (length > 90) {
        counter.classList.add('danger');
    } else if (length > 70) {
        counter.classList.add('warning');
    }
}

function updateStatusIndicator(select) {
    const indicator = document.getElementById('statusIndicator');
    const statusText = document.getElementById('statusText');
    const isActive = select.value === '1';
    
    // Remove current class and add animation
    indicator.style.animation = 'none';
    setTimeout(() => {
        indicator.className = 'status-indicator ' + (isActive ? 'active' : 'inactive');
        indicator.style.animation = '';
        statusText.textContent = isActive ? 'Đang hiển thị công khai' : 'Đang ẩn khỏi website';
    }, 10);
}

// Form submission animation
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('.btn-premium-primary');
    submitBtn.classList.add('loading');
});

// Initialize character counter on page load
document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="name_category"]');
    if (input) {
        updateCharCounter(input);
    }
});
</script>

@endsection