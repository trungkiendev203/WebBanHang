@extends('client.layouts.master')

@section('title', 'Tài khoản của tôi')

@section('content')
<style>
.account-page {
    background: #f5f5f5;
    padding: 50px 0;
}
.account-layout {
    max-width: 1100px;
    margin: auto;
    display: flex;
    gap: 30px;
}

/* ===== SIDEBAR ===== */
.account-sidebar {
    width: 260px;
    background: #fff;
    padding: 25px;
}
.account-sidebar h4 {
    margin-bottom: 20px;
    font-size: 16px;
}
.account-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.account-menu li {
    margin-bottom: 12px;
}
.account-menu a {
    color: #333;
    text-decoration: none;
    font-size: 14px;
}
.account-menu li.active a {
    font-weight: 600;
    color: #000;
}

/* ===== CONTENT ===== */
.account-content {
    flex: 1;
    background: #fff;
    padding: 35px;
}

/* ===== FORM COMMON ===== */
.form-group {
    margin-bottom: 18px;
}
.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
}
.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
}
.form-group input[disabled] {
    background: #f0f0f0;
}
.btn-save {
    padding: 12px 30px;
    background: #111;
    color: #fff;
    border: none;
    cursor: pointer;
}

/* ===== ALERT ===== */
.alert {
    padding: 10px;
    margin-bottom: 15px;
    font-size: 14px;
}
.alert-success { background: #e7f6ec; color: #0f5132; }
.alert-error { background: #fdecea; color: #842029; }
</style>

<div class="account-page">
    <div class="account-layout">

        {{-- SIDEBAR --}}
        <div class="account-sidebar">
            <h4>{{ $customer->name }}</h4>

            <ul class="account-menu">
                <li class="{{ $tab === 'profile' ? 'active' : '' }}">
                    <a href="{{ route('client.account', ['tab' => 'profile']) }}">
                        Thông tin tài khoản
                    </a>
                </li>

                <li class="{{ $tab === 'address' ? 'active' : '' }}">
                    <a href="{{ route('client.account', ['tab' => 'address']) }}">
                        Địa chỉ nhận hàng
                    </a>
                </li>


           
                <li class="{{ $tab === 'orders' ? 'active' : '' }}">
                    <a href="{{ route('client.account', ['tab' => 'orders']) }}">
                        Đơn hàng của tôi
                    </a>
                </li>
             

                <li>
                    <a href="{{ route('customer.logout') }}">Đăng xuất</a>
                </li>
            </ul>
        </div>

        {{-- CONTENT --}}
        <div class="account-content">

            @if($tab === 'profile')
                @include('client.account.partials.profile')

            @elseif($tab === 'address')
                @include('client.account.partials.address')


            @elseif($tab === 'orders')
                @include('client.account.partials.orders')
     

            @endif

        </div>

    </div>
</div>
@endsection
