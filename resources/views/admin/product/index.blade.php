@extends('admin.layouts.master')
@section('title', 'Quản lý sản phẩm')

@section('content')
<style>
/* ============================================
   🎨 MODERN GRADIENT THEME
============================================ */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
}

.page-header {
    background: var(--primary-gradient);
    padding: 2rem;
    border-radius: 20px;
    color: white;
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
    margin-bottom: 2rem;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

.page-header h2 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.page-header .subtitle {
    opacity: 0.95;
    font-size: 1.1rem;
}

.modern-btn {
    background: var(--success-gradient);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.modern-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(245, 87, 108, 0.6);
    color: white;
}

.search-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: none;
    margin-bottom: 2rem;
    overflow: hidden;
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.search-input {
    border: 2px solid #e9ecef;
    border-radius: 50px;
    padding: 12px 25px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-btn {
    background: var(--info-gradient);
    border: none;
    color: white;
    padding: 12px 35px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
}

.product-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
    animation: fadeIn 0.8s ease;
}

.table-modern {
    margin: 0;
}

.table-modern thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.table-modern thead th {
    border: none;
    padding: 1.2rem 1rem;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
}

.table-modern tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f0f0f0;
}

.table-modern tbody tr:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    transform: scale(1.01);
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.table-modern tbody td {
    padding: 1rem;
    vertical-align: middle;
}

.product-image {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    object-fit: cover;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.product-image:hover {
    transform: scale(1.1);
}

.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    font-size: 0.95rem;
}

.product-label {
    color: #95a5a6;
    font-size: 0.8rem;
}

.badge-modern {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.badge-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
}

.badge-gradient-danger {
    background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    color: white;
}

.badge-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.badge-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.badge-gradient-secondary {
    background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
    color: white;
}

.price-tag {
    font-size: 1rem;
    font-weight: 700;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.action-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.3s ease;
    margin: 0 3px;
}

.action-btn:hover {
    transform: translateY(-3px) scale(1.1);
}

.btn-edit {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(240, 147, 251, 0.3);
}

.btn-edit:hover {
    box-shadow: 0 5px 20px rgba(240, 147, 251, 0.5);
}

.btn-delete {
    background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(235, 51, 73, 0.3);
}

.btn-delete:hover {
    box-shadow: 0 5px 20px rgba(235, 51, 73, 0.5);
}

.btn-variant {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border: none;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-variant:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
    color: white;
}

.pagination-modern {
    border-radius: 20px;
    background: white;
    padding: 1.5rem;
    box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
}

.pagination-info {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state i {
    color: #bdc3c7;
    margin-bottom: 1.5rem;
}

.empty-state p {
    color: #95a5a6;
    font-size: 1.1rem;
}

.modal-modern .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 50px rgba(0,0,0,0.2);
}

.modal-modern .modal-header {
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 20px 20px 0 0;
    padding: 1.5rem 2rem;
}

.modal-modern .modal-title {
    font-weight: 700;
}

.modal-modern .btn-close {
    filter: brightness(0) invert(1);
}

.variant-table {
    margin-top: 1rem;
}

.variant-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.variant-table tbody tr {
    transition: all 0.2s ease;
}

.variant-table tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
}

/* Smooth scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}
</style>

<div class="container-fluid px-4">
    {{-- 🎨 Beautiful Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2>Quản lý Sản Phẩm</h2>
                <p class="subtitle mb-0">Tổng số: <strong>{{ $products->total() }}</strong> sản phẩm trong hệ thống</p>
            </div>
            <a href="{{ route('admin.product.create') }}" class="modern-btn">
                <i class="fas fa-plus-circle me-2"></i> Thêm sản phẩm mới
            </a>
        </div>
    </div>

    {{-- 🔍 Search Section --}}
    <div class="card search-card">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.product.index') }}" class="row g-3 align-items-center">
                <div class="col-md-10">
                    <input type="text" name="keyword" value="{{ $keyword ?? '' }}" 
                           class="form-control search-input" 
                           placeholder="🔍 Tìm kiếm theo tên hoặc mã sản phẩm...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn search-btn w-100">
                        <i class="fas fa-search me-2"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 📦 Product Table --}}
    <div class="card product-card">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width: 90px;">Mã SP</th>
                        <th style="width: 300px;">Sản phẩm</th>
                        <th class="text-center" style="width: 100px;">Tồn kho</th>
                        <th class="text-center" style="width: 100px;">Biến thể</th>
                        <th class="text-center" style="width: 140px;">Danh mục</th>
                        <th class="text-center" style="width: 140px;">Giá bán</th>
                        <th class="text-center" style="width: 120px;">Ngày tạo</th>
                        <th class="text-center" style="width: 120px;">Trạng thái</th>
                        <th class="text-center" style="width: 120px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $item)
                    @php 
                        $totalStock = $item->variants->sum('stock');
                    @endphp
                    <tr>
                        {{-- Mã SP --}}
                        <td>
                            <span class="badge badge-modern badge-gradient-secondary">
                                {{ $item->code_product }}
                            </span>
                        </td>

                        {{-- Sản phẩm --}}
                        <td>
                            <div class="product-info">
                                @if(Str::startsWith($item->image, ['http://', 'https://']))
                                    <img src="{{ $item->image }}" class="product-image">
                                @else
                                    <img src="{{ asset('uploads/product/' . $item->image) }}" class="product-image">
                                @endif
                                <div>
                                    <p class="product-name mb-1">{{ $item->name_product }}</p>
                                    <small class="product-label">
                                        <i class="fas fa-tag"></i> {{ $item->label->name_label ?? 'Chưa có nhãn' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        {{-- Tồn kho --}}
                        <td class="text-center">
                            @if($totalStock == 0)
                                <span class="badge badge-modern badge-gradient-danger">
                                    <i class="fas fa-times-circle"></i> Hết hàng
                                </span>
                            @elseif($totalStock < 10)
                                <span class="badge badge-modern badge-gradient-warning">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $totalStock }}
                                </span>
                            @else
                                <span class="badge badge-modern badge-gradient-success">
                                    <i class="fas fa-check-circle"></i> {{ $totalStock }}
                                </span>
                            @endif
                        </td>

                        {{-- Biến thể --}}
                        <td class="text-center">
                            @if($item->variants->count())
                                <button class="btn btn-variant btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#variantModal{{ $item->id_product }}">
                                    <i class="fas fa-boxes me-1"></i> {{ $item->variants->count() }}
                                </button>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Danh mục --}}
                        <td class="text-center">
                            <span class="badge badge-modern badge-gradient-info">
                                {{ $item->category->name_category ?? 'Chưa phân loại' }}
                            </span>
                        </td>

                        {{-- Giá bán --}}
                        <td class="text-center">
                            <span class="price-tag">{{ number_format($item->price_product) }}₫</span>
                        </td>

                        {{-- Ngày tạo --}}
                        <td class="text-center">
                            <small class="text-muted">
                                <i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d/m/Y') }}
                            </small>
                        </td>

                        {{-- Trạng thái --}}
                        <td class="text-center">
                            @if($item->status_product == '1')
                                <span class="badge badge-modern badge-gradient-success">
                                    <i class="fas fa-check"></i> Còn hàng
                                </span>
                            @else
                                <span class="badge badge-modern badge-gradient-secondary">
                                    <i class="fas fa-ban"></i> Ngừng bán
                                </span>
                            @endif
                        </td>

                        {{-- Thao tác --}}
                        <td class="text-center">
                            <a href="{{ route('admin.product.edit', $item->id_product) }}" 
                               class="action-btn btn-edit" 
                               title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" 
                                  action="{{ route('admin.product.destroy', $item->id_product) }}" 
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="action-btn btn-delete" 
                                        onclick="return confirm('⚠️ Bạn có chắc muốn xóa sản phẩm này không?')" 
                                        title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-box-open fa-4x"></i>
                                <p class="mb-0">Không tìm thấy sản phẩm nào</p>
                                <small class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc thêm sản phẩm mới</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📄 Pagination --}}
        @if($products->hasPages())
        <div class="pagination-modern">
            <div class="d-flex justify-content-between align-items-center">
                <div class="pagination-info">
                    Hiển thị <strong>{{ $products->firstItem() }}</strong> 
                    đến <strong>{{ $products->lastItem() }}</strong> 
                    trong tổng số <strong>{{ $products->total() }}</strong> sản phẩm
                </div>
                <div>
                    {{ $products->appends(['keyword' => $keyword ?? ''])->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- 🎭 Modal Biến thể --}}
@foreach($products as $item)
<div class="modal fade modal-modern" id="variantModal{{ $item->id_product }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-boxes me-2"></i> Biến thể của: {{ $item->name_product }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                @if($item->variants->count())
                <div class="table-responsive">
                    <table class="table variant-table">
                        <thead>
                            <tr class="text-center">
                                <th>SKU</th>
                                <th>Size</th>
                                <th>Màu sắc</th>
                                <th>Giá</th>
                                <th>Tồn kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->variants as $v)
                            <tr class="text-center">
                                <td><code class="badge badge-gradient-secondary">{{ $v->sku }}</code></td>
                                <td><span class="badge badge-modern badge-gradient-info">{{ $v->size }}</span></td>
                                <td>
                                    <span class="badge badge-modern" style="background: {{ $v->color }}; color: white;">
                                        {{ $v->color }}
                                    </span>
                                </td>
                                <td><strong class="price-tag">{{ number_format($v->price) }}₫</strong></td>
                                <td>
                                    <span class="badge badge-modern {{ $v->stock > 0 ? 'badge-gradient-success' : 'badge-gradient-danger' }}">
                                        {{ $v->stock }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-info-circle fa-3x"></i>
                    <p>Sản phẩm này chưa có biến thể nào</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection