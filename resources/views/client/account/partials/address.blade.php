<h3>Địa chỉ nhận hàng</h3>

{{-- THÔNG BÁO --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

{{-- ===== FORM THÊM ĐỊA CHỈ ===== --}}
<form action="{{ route('client.address.store') }}" method="POST" style="margin-bottom:30px">
    @csrf

    <div class="form-group">
        <label>Tên người nhận</label>
        <input type="text" name="name_receiver" required>
    </div>

    <div class="form-group">
        <label>Số điện thoại nhận hàng</label>
        <input type="text" name="phone_receiver" required>
    </div>

<div class="form-group">
    <label>Tỉnh / Thành phố</label>
    <select name="province" id="province" required>
        <option value="">Chọn Tỉnh/TP</option>
    </select>
</div>

<div class="form-group">
    <label>Quận / Huyện</label>
    <select name="district" id="district" required>
        <option value="">Chọn Quận/Huyện</option>
    </select>
</div>

<div class="form-group">
    <label>Phường / Xã</label>
    <select name="ward" id="ward" required>
        <option value="">Chọn Phường/Xã</option>
    </select>
</div>


    <div class="form-group">
        <label>Địa chỉ chi tiết</label>
        <input type="text" name="address_detail" required>
    </div>

    <label style="display:block;margin-bottom:20px">
        <input type="checkbox" name="is_default">
        Đặt làm địa chỉ mặc định
    </label>

    <button type="submit" class="btn-save">
        Thêm địa chỉ
    </button>
</form>

<hr>

{{-- ===== DANH SÁCH ĐỊA CHỈ ===== --}}
@if($addresses->count())
    @foreach($addresses as $address)
        <div style="border:1px solid #ddd;padding:15px;margin-bottom:15px">

            <strong>{{ $address->name_receiver }}</strong>
            - {{ $address->phone_receiver }}

            @if($address->is_default)
                <span style="color:green;font-weight:600">
                    (Mặc định)
                </span>
            @endif

            <div style="margin:8px 0">
                {{ $address->address_detail }},
                {{ $address->ward }},
                {{ $address->district }},
                {{ $address->province }}
            </div>

            <div>
                @if(!$address->is_default)
                    <form action="{{ route('client.address.default', $address->id_address) }}"
                          method="POST"
                          style="display:inline">
                        @csrf
                        <button type="submit">Đặt mặc định</button>
                    </form>
                @endif

                <form action="{{ route('client.address.delete', $address->id_address) }}"
                      method="POST"
                      style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Xóa địa chỉ này?')">
                        Xóa
                    </button>
                </form>
            </div>

        </div>
    @endforeach
@else
    <p>Chưa có địa chỉ nào.</p>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');
    const userProvince = '';
const userDistrict = '';
const userWard = '';

    // 1️⃣ Load tỉnh
    fetch('https://provinces.open-api.vn/api/p/')
        .then(res => res.json())
        .then(data => {
            data.forEach(p => {
                const selected = p.name === userProvince ? 'selected' : '';
                provinceSelect.innerHTML += `
                    <option value="${p.name}" data-code="${p.code}" ${selected}>
                        ${p.name}
                    </option>
                `;
            });

            if (userProvince) provinceSelect.dispatchEvent(new Event('change'));
        });

    // 2️⃣ Load huyện
    provinceSelect.addEventListener('change', function () {
        const code = this.selectedOptions[0]?.dataset.code;
        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        if (!code) return;

        fetch(`https://provinces.open-api.vn/api/p/${code}?depth=2`)
            .then(res => res.json())
            .then(data => {
                data.districts.forEach(d => {
                    const selected = d.name === userDistrict ? 'selected' : '';
                    districtSelect.innerHTML += `
                        <option value="${d.name}" data-code="${d.code}" ${selected}>
                            ${d.name}
                        </option>
                    `;
                });

                if (userDistrict) districtSelect.dispatchEvent(new Event('change'));
            });
    });

    // 3️⃣ Load xã
    districtSelect.addEventListener('change', function () {
        const code = this.selectedOptions[0]?.dataset.code;
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        if (!code) return;

        fetch(`https://provinces.open-api.vn/api/d/${code}?depth=2`)
            .then(res => res.json())
            .then(data => {
                data.wards.forEach(w => {
                    const selected = w.name === userWard ? 'selected' : '';
                    wardSelect.innerHTML += `
                        <option value="${w.name}" ${selected}>
                            ${w.name}
                        </option>
                    `;
                });
            });
    });
});
</script>
