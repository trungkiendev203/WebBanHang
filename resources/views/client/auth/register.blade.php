@extends('client.layouts.master')

@section('title', 'Đăng ký tài khoản')

@section('content')
<style>
.register-wrapper {
    padding: 60px 0;
    background: #f5f5f5;
}
.register-container {
    max-width: 500px;
    margin: auto;
    background: #fff;
    padding: 40px;
}
.register-container h3 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 22px;
}
.register-container input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}
.register-container button {
    width: 100%;
    padding: 12px;
    background: #111;
    color: #fff;
    border: none;
    cursor: pointer;
}
.register-container button:hover {
    background: #000;
}
.alert {
    padding: 10px;
    margin-bottom: 15px;
    font-size: 14px;
}
.alert-error { background: #fdecea; color: #842029; }
.alert-success { background: #e7f6ec; color: #0f5132; }
.register-extra {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}
.register-extra a {
    color: #000;
    text-decoration: underline;
}
</style>

<div class="register-wrapper">
    <div class="register-container">
        <h3>Đăng ký tài khoản</h3>

        {{-- THÔNG BÁO --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- FORM ĐĂNG KÝ --}}
        <form action="{{ route('customer.register') }}" method="POST">
            @csrf

            <input 
                type="text" 
                name="name" 
                placeholder="Họ và tên"
                value="{{ old('name') }}"
                required
            >

            <input 
                type="email" 
                name="email" 
                placeholder="Email"
                value="{{ old('email') }}"
                required
            >

            <input 
                type="text" 
                name="phone" 
                placeholder="Số điện thoại"
                value="{{ old('phone') }}"
                required
            >

            <input 
                type="password" 
                name="password" 
                placeholder="Mật khẩu (tối thiểu 6 ký tự)"
                required
            >

            <button type="submit">TẠO TÀI KHOẢN</button>
        </form>

        <div class="register-extra">
            <p>🎁 Đăng ký nhận <strong>voucher 10%</strong> cho đơn mua đầu tiên</p>
            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
        </div>
    </div>
</div>
@endsection
