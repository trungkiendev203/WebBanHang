@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Cập nhật sự kiện</h3>

    <form action="{{ route('admin.event.update', $event->id_event) }}" method="POST">
        @csrf

        {{-- ===== THÔNG TIN SỰ KIỆN ===== --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Thông tin sự kiện</strong>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Tiêu đề sự kiện</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ $event->title }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả ngắn</label>
                    <input type="text"
                           name="subtitle"
                           class="form-control"
                           value="{{ $event->subtitle }}">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Badge</label>
                        <input type="text"
                               name="badge_text"
                               class="form-control"
                               value="{{ $event->badge_text }}"
                               placeholder="SALE / HOT">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Màu badge</label>
                        <input type="color"
                               name="badge_color"
                               class="form-control form-control-color"
                               value="{{ $event->badge_color }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vị trí hiển thị</label>
                        <select name="position" class="form-control">
                            <option value="header" {{ $event->position == 'header' ? 'selected' : '' }}>
                                Header
                            </option>
                            <option value="banner" {{ $event->position == 'banner' ? 'selected' : '' }}>
                                Banner
                            </option>
                            <option value="popup" {{ $event->position == 'popup' ? 'selected' : '' }}>
                                Popup
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thời gian bắt đầu</label>
                        <input type="datetime-local"
                               name="start_date"
                               class="form-control"
                               value="{{ date('Y-m-d\TH:i', strtotime($event->start_date)) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thời gian kết thúc</label>
                        <input type="datetime-local"
                               name="end_date"
                               class="form-control"
                               value="{{ date('Y-m-d\TH:i', strtotime($event->end_date)) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>
                        <input type="checkbox"
                               name="status"
                               value="1"
                               {{ $event->status ? 'checked' : '' }}>
                        Kích hoạt sự kiện
                    </label>
                </div>

            </div>
        </div>

        {{-- ===== SẢN PHẨM ÁP DỤNG ===== --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Sản phẩm áp dụng cho sự kiện</strong>
            </div>

            <div class="card-body">
                <p class="text-muted" style="font-size:13px">
                    Tick các sản phẩm sẽ hiển thị trong sự kiện này
                </p>

                <div class="event-product-box">
                    @foreach($products as $product)
                        <label class="event-product-item">
                            <input type="checkbox"
                                   name="products[]"
                                   value="{{ $product->id_product }}"
                                   {{ in_array($product->id_product, $selectedProducts) ? 'checked' : '' }}>
                            <span>{{ $product->name_product }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===== ACTION ===== --}}
        <div class="mb-4">
            <button type="submit" class="btn btn-success">
                💾 Lưu thay đổi
            </button>

            <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
                ⬅ Quay lại
            </a>
        </div>

    </form>
</div>

{{-- ===== CSS NHẸ ===== --}}
<style>
.event-product-box {
    max-height: 320px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px;
    background: #fafafa;
}

.event-product-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 8px;
    border-radius: 4px;
    cursor: pointer;
}

.event-product-item:hover {
    background: #f0f0f0;
}

.event-product-item input {
    transform: scale(1.1);
}
</style>

@endsection
