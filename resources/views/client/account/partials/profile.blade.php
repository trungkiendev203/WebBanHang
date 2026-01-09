<h3>Thông tin tài khoản</h3>

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

{{-- FORM CẬP NHẬT --}}
<form action="{{ route('client.account.update') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Họ và tên</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $customer->name) }}"
            required
        >
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input
            type="text"
            name="phone"
            value="{{ old('phone', $customer->phone) }}"
            required
        >
    </div>

    <div class="form-group">
        <label>Email</label>
        <input
            type="email"
            value="{{ $customer->email }}"
            disabled
        >
    </div>

    <button type="submit" class="btn-save">
        LƯU THAY ĐỔI
    </button>
</form>

<div style="margin-top:20px">
    <a href="{{ route('customer.logout') }}">Đăng xuất</a>
</div>
