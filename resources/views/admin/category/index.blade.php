@extends('admin.layouts.master')
@section('title', 'Danh sách loại sản phẩm')

@section('content')
<style>
    .category-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    .category-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .category-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem 2rem;
        border: none;
    }
    
    .category-header h5 {
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .category-header h5 i {
        font-size: 1.8rem;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .btn-add-new {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .btn-add-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        color: #764ba2;
        background: #f8f9fa;
    }
    
    .search-wrapper {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 1.5rem;
    }
    
    .search-input {
        border: 2px solid #e0e0e0;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-search {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-search:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .modern-table {
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .modern-table thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(90deg, #f8f9fa 0%, #e9ecef 100%);
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .modern-table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-active {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .badge-inactive {
        background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
        color: white;
    }
    
    .btn-action {
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    
    .btn-delete:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(250, 112, 154, 0.4);
    }
    
    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #95a5a6;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .category-code {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-family: 'Courier New', monospace;
    }
    
    .parent-category {
        background: #f8f9fa;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        color: #495057;
        font-weight: 500;
    }
</style>

<div class="category-container">
    <div class="category-card">
        <div class="category-header d-flex justify-content-between align-items-center">
            <h5>
                <i class="fas fa-layer-group"></i>
                Quản lý Loại sản phẩm
            </h5>
            <a href="{{ route('admin.category.create') }}" class="btn-add-new">
                <i class="fas fa-plus-circle me-2"></i>Thêm mới
            </a>
        </div>

        <div class="card-body p-4">
            <!-- Thanh tìm kiếm -->
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.category.index') }}">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control search-input" 
                               placeholder="🔍 Tìm kiếm theo tên hoặc mã loại sản phẩm..."
                               value="{{ request('keyword') }}">
                        <button class="btn btn-search" type="submit">
                            <i class="fas fa-search me-2"></i>Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bảng danh sách -->
            <div class="table-responsive">
                <table class="table modern-table align-middle">
                    <thead>
                        <tr>
                            <th style="width:5%">#</th>
                            <th style="width:15%">Mã loại</th>
                            <th style="width:25%">Tên loại sản phẩm</th>
                            <th style="width:25%">Thuộc loại</th>
                            <th style="width:15%">Trạng thái</th>
                            <th style="width:15%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $c)
                            <tr>
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <span class="category-code">{{ $c->code_category ?? '—' }}</span>
                                </td>
                                <td class="fw-semibold">{{ $c->name_category }}</td>
                                <td class="text-center">
                                    <span class="parent-category">
                                        <i class="fas fa-folder-tree me-1"></i>
                                        {{ $c->parent ? $c->parent->name_category : 'Danh mục gốc' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($c->status_category == '1')
                                        <span class="badge-status badge-active">
                                            <i class="fas fa-eye me-1"></i>Hiển thị
                                        </span>
                                    @else
                                        <span class="badge-status badge-inactive">
                                            <i class="fas fa-eye-slash me-1"></i>Ẩn
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.category.edit', $c->id_category) }}" 
                                       class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.category.destroy', $c->id_category) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn-action btn-delete" 
                                                onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa loại sản phẩm này không?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Chưa có loại sản phẩm nào</h5>
                                        <p class="text-muted">Hãy thêm loại sản phẩm đầu tiên của bạn</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection