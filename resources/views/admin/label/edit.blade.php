@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa hiệu sản phẩm')

@section('content')
<style>
    .modern-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .modern-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 24px 32px;
        border: none;
    }

    .card-header-modern h5 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-header-modern h5::before {
        content: "✏️";
        font-size: 24px;
    }

    .card-body-modern {
        padding: 32px;
    }

    .form-label-modern {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label-modern::before {
        content: "●";
        color: #667eea;
        font-size: 12px;
    }

    .form-control-modern {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background-color: white;
        transform: translateY(-1px);
    }

    .form-control-modern:hover {
        border-color: #cbd5e0;
        background-color: white;
    }

    .form-select-modern {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 15px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 45px;
    }

    .form-select-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background-color: white;
        transform: translateY(-1px);
    }

    .form-select-modern:hover {
        border-color: #cbd5e0;
        background-color: white;
    }

    .form-group-modern {
        margin-bottom: 24px;
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-group-modern:nth-child(2) {
        animation-delay: 0.1s;
    }

    .btn-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid #f1f5f9;
    }

    .btn-modern {
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-success-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-success-modern:active {
        transform: translateY(0);
    }

    .btn-secondary-modern {
        background: #f1f5f9;
        color: #475569;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary-modern:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary-modern:active {
        transform: translateY(0);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 8px;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .help-text {
        font-size: 13px;
        color: #64748b;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .help-text::before {
        content: "ℹ️";
        font-size: 14px;
    }

    .input-counter {
        position: absolute;
        right: 18px;
        bottom: 14px;
        font-size: 12px;
        color: #94a3b8;
        pointer-events: none;
    }

    .input-wrapper {
        position: relative;
    }

    @media (max-width: 768px) {
        .btn-actions {
            flex-direction: column;
        }
        
        .btn-modern {
            width: 100%;
            justify-content: center;
        }
        
        .card-body-modern {
            padding: 24px 20px;
        }
    }
</style>

<div class="modern-card">
    <div class="card-header-modern">
        <h5>Chỉnh sửa hiệu sản phẩm</h5>
    </div>
    <div class="card-body-modern">
        <form action="{{ route('admin.label.update', $label->id_label) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group-modern">
                <label class="form-label-modern">Tên hiệu sản phẩm</label>
                <div class="input-wrapper">
                    <input 
                        type="text" 
                        name="name_label" 
                        class="form-control-modern" 
                        value="{{ $label->name_label }}" 
                        placeholder="Nhập tên hiệu sản phẩm..."
                        maxlength="100"
                        oninput="updateCounter(this)"
                        required
                    >
                    <span class="input-counter">
                        <span id="char-count">{{ strlen($label->name_label) }}</span>/100
                    </span>
                </div>
                <div class="help-text">Tên hiệu sản phẩm sẽ hiển thị trên website</div>
            </div>

            <div class="form-group-modern">
                <label class="form-label-modern">Trạng thái hiển thị</label>
                <select name="status_label" class="form-select-modern" onchange="updateStatusBadge(this)">
                    <option value="1" {{ $label->status_label == '1' ? 'selected' : '' }}>✅ Hiển thị</option>
                    <option value="0" {{ $label->status_label == '0' ? 'selected' : '' }}>🚫 Ẩn</option>
                </select>
                <div id="status-badge" class="status-badge {{ $label->status_label == '1' ? 'active' : 'inactive' }}">
                    <span>●</span>
                    <span>{{ $label->status_label == '1' ? 'Đang hiển thị' : 'Đang ẩn' }}</span>
                </div>
                <div class="help-text">Chọn trạng thái hiển thị của hiệu sản phẩm</div>
            </div>

            <div class="btn-actions">
                <button type="submit" class="btn-modern btn-success-modern">
                    <span>💾</span>
                    Cập nhật thay đổi
                </button>
                <a href="{{ route('admin.label.index') }}" class="btn-modern btn-secondary-modern">
                    <span>←</span>
                    Quay lại danh sách
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function updateCounter(input) {
    const counter = document.getElementById('char-count');
    counter.textContent = input.value.length;
    
    // Thêm hiệu ứng khi gần đạt giới hạn
    if (input.value.length > 80) {
        counter.style.color = '#dc2626';
        counter.style.fontWeight = 'bold';
    } else {
        counter.style.color = '#94a3b8';
        counter.style.fontWeight = 'normal';
    }
}

function updateStatusBadge(select) {
    const badge = document.getElementById('status-badge');
    const isActive = select.value === '1';
    
    badge.className = 'status-badge ' + (isActive ? 'active' : 'inactive');
    badge.innerHTML = '<span>●</span><span>' + (isActive ? 'Đang hiển thị' : 'Đang ẩn') + '</span>';
}
</script>

@endsection