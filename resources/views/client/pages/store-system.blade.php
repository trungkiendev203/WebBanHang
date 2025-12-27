@extends('client.layouts.master')

@section('title', 'Hệ thống cửa hàng')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-semibold">Hệ thống cửa hàng</h1>

    <div class="store-wrapper">
        {{-- MAP --}}
<div class="map-box">
<iframe
    id="mapFrame"
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1864.6093436675226!2d106.55650879431437!3d20.82287385053928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a77c240000001%3A0x7eca11697378fa29!2sTHPT%20An%20L%C3%A3o!5e0!3m2!1svi!2sus!4v1766804519530!5m2!1svi!2sus"
    allowfullscreen
    loading="lazy">
</iframe>
</div>


        {{-- STORE LIST --}}
        <div class="store-list">

            <select class="form-select mb-3" id="citySelect">
                <option value="">Chọn Tỉnh Thành</option>
                <option value="ha_noi">Hà Nội</option>
                <option value="hai_phong">Hải Phòng</option>
            </select>

            {{-- DANH SÁCH SHOP --}}
            <div id="storeList"></div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const stores = @json($stores);

    const citySelect = document.getElementById('citySelect');
    const mapFrame = document.getElementById('mapFrame');
    const storeList = document.getElementById('storeList');

    citySelect.addEventListener('change', function () {
        const city = this.value;

        storeList.innerHTML = '';
        mapFrame.src = '';

        if (!city || !stores[city]) return;

        // Map shop đầu tiên
        mapFrame.src = stores[city][0].map;

        stores[city].forEach(store => {
            const div = document.createElement('div');
            div.classList.add('store-item');

            div.innerHTML = `
                <h6>${store.name}</h6>
                <p>📍 ${store.address}</p>
                <p>📞 ${store.phone}</p>
            `;

            div.onclick = () => {
                mapFrame.src = store.map;
            };

            storeList.appendChild(div);
        });
    });
</script>
@endpush

@push('styles')
<style>
.store-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
}

.map-box iframe {
    width: 100%;
    height: 500px;
    border-radius: 6px;
    border: 1px solid #e5e5e5;
}

.store-list {
    background: #fafafa;
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 6px;
}

.store-item {
    border-bottom: 1px dashed #ddd;
    padding-bottom: 12px;
    margin-bottom: 12px;
}

.store-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.store-item h6 {
    font-weight: 600;
    margin-bottom: 5px;
}

.store-item p {
    margin: 0;
    font-size: 14px;
}

@media (max-width: 768px) {
    .store-wrapper {
        grid-template-columns: 1fr;
    }

    .map-box iframe {
        height: 350px;
    }
}
</style>

@endpush
