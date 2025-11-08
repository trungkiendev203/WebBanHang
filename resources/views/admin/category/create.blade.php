@extends('admin.layouts.master')
@section('title', 'Thêm loại sản phẩm')

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

    @keyframes slideInRight {
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
            transform: translateY(-10px);
        }
    }

    @keyframes glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }
        50% {
            box-shadow: 0 0 40px rgba(118, 75, 162, 0.8);
        }
    }

    .create-category-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem;
        animation: fadeInUp 0.6s ease-out;
    }

    .create-category-card {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        max-width: 800px;
        margin: 0 auto;
        animation: fadeInUp 0.8s ease-out;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    .card-header-custom h5 {
        color: white;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 1;
        animation: slideInRight 0.8s ease-out;
    }

    .card-header-custom h5 i {
        font-size: 2.5rem;
        animation: float 3s ease-in-out infinite;
    }

    .form-container {
        padding: 3rem;
    }

    .form-group-animated {
        margin-bottom: 2rem;
        animation: slideInRight 0.6s ease-out;
        animation-fill-mode: both;
    }

    .form-group-animated:nth-child(1) { animation-delay: 0.1s; }
    .form-group-animated:nth-child(2) { animation-delay: 0.2s; }
    .form-group-animated:nth-child(3) { animation-delay: 0.3s; }
    .form-group-animated:nth-child(4) { animation-delay: 0.4s; }

    .form-label-custom {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.1rem;
    }

    .form-label-custom i {
        color: #667eea;
        font-size: 1.2rem;
    }

    .required-star {
        color: #e74c3c;
        margin-left: 0.25rem;
    }

    .form-control-custom {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: white;
        transform: translateY(-2px);
        animation: glow 2s ease-in-out infinite;
    }

    .form-control-custom:hover {
        border-color: #764ba2;
        background: white;
    }

    .form-select-custom {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat right 1rem center/16px 12px;
        cursor: pointer;
    }

    .form-select-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background-color: white;
        transform: translateY(-2px);
    }

    .form-select-custom:hover {
        border-color: #764ba2;
        background-color: white;
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        font-size: 1.2rem;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus ~ .input-icon {
        color: #764ba2;
        animation: float 2s ease-in-out infinite;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        animation: fadeInUp 0.8s ease-out 0.5s;
        animation-fill-mode: both;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1rem 3rem;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
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

    .btn-submit:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-submit:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
    }

    .btn-submit:active {
        transform: translateY(-2px);
    }

    .btn-back {
        background: white;
        border: 2px solid #667eea;
        padding: 1rem 3rem;
        border-radius: 50px;
        color: #667eea;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
    }

    .decorative-circle {
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }

    .circle-1 {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
        top: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .circle-2 {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(118, 75, 162, 0.1) 0%, transparent 70%);
        bottom: -50px;
        left: -50px;
        animation: float 6s ease-in-out infinite reverse;
    }

    .helper-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .helper-text i {
        color: #667eea;
    }
</style>

<div class="create-category-wrapper">
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>

    <div class="create-category-card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-plus-circle"></i>
                Thêm mới loại sản phẩm
            </h5>
        </div>

        <div class="form-container">
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                
                <div class="form-group-animated">
                    <label class="form-label-custom">
                        <i class="fas fa-barcode"></i>
                        Mã loại sản phẩm
                        <span class="required-star">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" 
                               name="code_category" 
                               class="form-control form-control-custom" 
                               placeholder="VD: CAT001, TECH2024..." 
                               required>
                        <i class="fas fa-hashtag input-icon"></i>
                    </div>
                    <div class="helper-text">
                        <i class="fas fa-info-circle"></i>
                        Mã định danh duy nhất cho loại sản phẩm
                    </div>
                </div>

                <div class="form-group-animated">
                    <label class="form-label-custom">
                        <i class="fas fa-tag"></i>
                        Tên loại sản phẩm
                        <span class="required-star">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" 
                               name="name_category" 
                               class="form-control form-control-custom" 
                               placeholder="VD: Điện thoại, Laptop, Phụ kiện..." 
                               required>
                        <i class="fas fa-pencil-alt input-icon"></i>
                    </div>
                    <div class="helper-text">
                        <i class="fas fa-info-circle"></i>
                        Tên hiển thị của loại sản phẩm
                    </div>
                </div>

                <div class="form-group-animated">
                    <label class="form-label-custom">
                        <i class="fas fa-folder-tree"></i>
                        Thuộc loại
                    </label>
                    <select name="parent_id" class="form-select form-select-custom">
                        <option value="">📁 Danh mục gốc (Không có danh mục cha)</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_category }}">
                                {{ $category->display_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="helper-text">
                        <i class="fas fa-info-circle"></i>
                        Chọn danh mục cha nếu đây là danh mục con
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-check-circle me-2"></i>
                        Thêm mới
                    </button>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Thêm hiệu ứng ripple khi click button
    document.querySelectorAll('.btn-submit, .btn-back').forEach(button => {
        button.addEventListener('click', function(e) {
            let ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Thêm hiệu ứng shake khi submit form trống
    document.querySelector('form').addEventListener('submit', function(e) {
        const inputs = this.querySelectorAll('input[required]');
        let hasError = false;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                hasError = true;
                input.style.animation = 'none';
                setTimeout(() => {
                    input.style.animation = 'shake 0.5s';
                }, 10);
            }
        });
    });

    // Animation shake
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.6);
            width: 20px;
            height: 20px;
            animation: ripple-effect 0.6s ease-out;
            pointer-events: none;
        }
        
        @keyframes ripple-effect {
            to {
                width: 200px;
                height: 200px;
                opacity: 0;
                transform: translate(-50%, -50%);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection