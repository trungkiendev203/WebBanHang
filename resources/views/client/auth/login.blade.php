@extends('client.layouts.master')

@section('title', 'Đăng nhập / Đăng ký')

@section('content')
<style>
.auth-wrapper {
    padding: 60px 0;
    background: #f5f5f5;
}
.auth-container {
    max-width: 1100px;
    margin: auto;
    background: #fff;
    padding: 40px;
}
.auth-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}
.auth-box h3 {
    margin-bottom: 20px;
    font-size: 20px;
}
.auth-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}
.google-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #333;
    font-size: 14px;
    background: #fff;
    transition: all 0.2s;
}

.google-btn img {
    width: 18px;
    height: 18px;
}

.google-btn:hover {
    background: #f7f7f7;
    border-color: #ccc;
}

.auth-box button {
    width: 100%;
    padding: 12px;
    background: #111;
    color: #fff;
    border: none;
    cursor: pointer;
}
.auth-box button:hover {
    background: #000;
}
.auth-extra {
    margin-top: 15px;
    font-size: 14px;
}
.auth-extra a {
    color: #000;
    text-decoration: underline;
}
.alert {
    padding: 10px;
    margin-bottom: 15px;
    font-size: 14px;
}
.alert-success { background: #e7f6ec; color: #0f5132; }
.alert-error { background: #fdecea; color: #842029; }
</style>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-grid">

            {{-- ================= ĐĂNG NHẬP ================= --}}
            <div class="auth-box">
                <h3>Đăng nhập</h3>

                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('customer.login') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mật khẩu" required>

                    <div class="auth-extra">
                        <a href="#">Quên mật khẩu?</a>
                    </div>

                    <button type="submit">ĐĂNG NHẬP</button>
                    <div style="margin: 20px 0; text-align: center;">
    <span style="font-size:14px;color:#999;">hoặc</span>
</div>

<a href="{{ route('google.login') }}" class="google-btn">
    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google">
    Đăng nhập bằng Google
</a>

                </form>

                <div class="auth-extra">
                    <p>🎁 Đơn đầu giảm 10% + 100 điểm tích lũy</p>
                </div>
            </div>

            {{-- ================= ĐĂNG KÝ ================= --}}
            <div class="auth-box">
                <h3>Đăng ký</h3>

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('customer.register') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}" required>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    <input type="text" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}" required>
                    <input type="password" name="password" placeholder="Mật khẩu" required>

                    <button type="submit">TẠO TÀI KHOẢN</button>
                </form>

                <div class="auth-extra">
                    <p>Đăng ký nhận <strong>voucher 10%</strong> cho đơn tiếp theo</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
