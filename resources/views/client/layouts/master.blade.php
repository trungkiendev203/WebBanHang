<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KienQuanh - Thời trang cao cấp')</title>

    {{-- Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- SwiperJS (slider) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    {{-- CSS custom --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@stack('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* ===== HEADER STYLES ===== */
        .main-header {
            background: white;
            border-bottom: 1px solid #e5e5e5;
            padding: 15px 0;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            margin-right: 8px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 400;
            color: #333;
            line-height: 1.2;
        }

        /* Main Navigation */
        .main-nav {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .main-nav ul {
            list-style: none;
            display: flex;
            gap: 35px;
            margin: 0;
            padding: 0;
        }

        .main-nav a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s;
            position: relative;
            padding: 5px 0;
        }

        .main-nav a:hover {
            color: #000;
        }

        /* Sale Badge */
        .sale-badge {
            position: absolute;
            top: -10px;
            right: -15px;
            background: #e31e24;
            color: white;
            font-size: 9px;
            padding: 2px 5px;
            border-radius: 2px;
            font-weight: 600;
        }

        .nav-item {
            position: relative;
        }

        /* Header Icons */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-actions a {
            color: #333;
            font-size: 20px;
            text-decoration: none;
            position: relative;
            transition: color 0.3s;
        }

        .header-actions a:hover {
            color: #000;
        }

        .icon-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #333;
            color: white;
            font-size: 11px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        /* Info Bar */
        .info-bar {
            background: #f8f8f8;
            border-bottom: 1px solid #e5e5e5;
            padding: 12px 0;
        }

        .info-bar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            font-size: 13px;
        }

        .info-item i {
            font-size: 24px;
            color: #999;
        }
        #chat-icon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            z-index: 9999;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        #chat-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
            50% {
                box-shadow: 0 10px 40px rgba(102, 126, 234, 0.7);
            }
        }

        /* Hiệu ứng notification dot */
        #chat-icon::before {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 12px;
            height: 12px;
            background: #ff4757;
            border-radius: 50%;
            border: 2px solid white;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        /* CHAT BOX - Cửa sổ chat */
        #chat-box {
            position: fixed;
            bottom: 115px;
            right: 30px;
            width: 380px;
            height: 550px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 9999;
            animation: slideUp 0.4s ease;
        }

        #chat-box.show {
            display: flex;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CHAT HEADER */
        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .chat-avatar {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            backdrop-filter: blur(10px);
        }

        .chat-info {
            flex: 1;
        }

        .chat-info h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .chat-info p {
            margin: 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .online-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #2ecc71;
            border-radius: 50%;
            margin-right: 5px;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        #chat-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 24px;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        #chat-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        /* CHAT BODY */
        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        /* Message Styles */
        .message {
            display: flex;
            gap: 10px;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .message.bot .message-avatar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .message.user .message-avatar {
            background: #e0e7ff;
            color: #667eea;
        }

        .message-content {
            max-width: 70%;
        }

        .message-bubble {
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
            word-wrap: break-word;
        }

        .message.bot .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .message.user .message-bubble {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .message-time {
            font-size: 11px;
            opacity: 0.6;
            margin-top: 5px;
            text-align: right;
        }

        .message.bot .message-time {
            text-align: left;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;
            padding: 12px 16px;
            background: white;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            width: fit-content;
        }

        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #cbd5e0;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }

        /* Quick Replies */
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .quick-reply-btn {
            background: white;
            border: 1px solid #e0e7ff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            color: #667eea;
            cursor: pointer;
            transition: all 0.3s;
        }

        .quick-reply-btn:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* CHAT FOOTER */
        .chat-footer {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        #chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        #chat-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .chat-footer button {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s;
        }

        .chat-footer button:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .chat-footer button:active {
            transform: scale(0.95);
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            #chat-box {
                width: calc(100vw - 20px);
                right: 10px;
                bottom: 100px;
                height: calc(100vh - 120px);
                max-height: 600px;
            }

            #chat-icon {
                right: 20px;
                bottom: 20px;
            }
        }
        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        /* ===== FOOTER STYLES ===== */
        footer {
            background: #1a1a1a;
            color: #999;
            padding: 50px 0 20px;
            margin-top: 80px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        footer h5 {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .menu-tab a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    padding-bottom: 6px;
    position: relative;
}

.menu-tab a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0;
    height: 2px;
    background: #000;
    transition: width 0.3s ease;
}

.menu-tab a:hover::after {
    width: 100%;
}

.menu-tab a:hover {
    color: #000;
}


        footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        footer ul li {
            margin-bottom: 10px;
        }

        footer a {
            color: #999;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #fff;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            font-size: 20px;
        }

        .newsletter-form {
            display: flex;
            margin-top: 15px;
        }

        .newsletter-form input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #333;
            background: #2a2a2a;
            color: #fff;
            font-size: 13px;
            outline: none;
        }

        .newsletter-form button {
            padding: 10px 20px;
            background: #fff;
            color: #000;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .newsletter-form button:hover {
            background: #e5e5e5;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .dmca-badge {
            display: inline-block;
            margin-top: 15px;
            opacity: 0.7;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .main-nav {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .info-bar-container {
                flex-direction: column;
                gap: 10px;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .header-container {
                padding: 0 15px;
            }

            .info-item span {
                display: none;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @stack('css')
</head>

<body>
   <!-- ✅ THÔNG BÁO SUCCESS/ERROR -->
    @if(session('success'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: #28a745; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-weight: 500;">
            ✓ {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('div[style*="position: fixed"]').style.display = 'none';
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: #dc3545; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-weight: 500;">
            ✗ {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('div[style*="position: fixed"]').style.display = 'none';
            }, 5000);
        </script>
    @endif
    {{-- ===========================
         MAIN HEADER
    ============================ --}}
    <header class="main-header">
        <div class="header-container">
            
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="logo">
                <svg class="logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="4" fill="#333"/>
                    <path d="M12 12h16v16H12z" fill="#fff"/>
                    <path d="M15 15h10v10H15z" fill="#333"/>
                </svg>
                <div class="logo-text">
                    KienQuanh
                </div>
            </a>
            {{-- Main Navigation --}}
            <nav class="main-nav">
                <ul>
@if(isset($eventHeader))
<li class="nav-item">
    <a href="{{ route('client.event.index', $eventHeader->id_event) }}">
        {{ $eventHeader->title }}

        @if($eventHeader->badge_text)
            <span class="sale-badge"
                  style="background: {{ $eventHeader->badge_color }}">
                {{ $eventHeader->badge_text }}
            </span>
        @endif
    </a>
</li>
@endif


                    <li><a href="{{ route('client.category', 'dam') }}">ĐẦM</a></li>
                    <li><a href="{{ route('client.category', 'ao') }}">ÁO</a></li>
                    <li><a href="{{ route('client.category', 'quan') }}">QUẦN</a></li>
                    <li><a href="{{ route('client.category', 'chan-vay') }}">CHÂN VÁY</a></li>
                    <li><a href="{{ route('client.category', 'ao-khoac') }}">ÁO KHOÁC</a></li>
                    <li><a href="#">LOOKBOOK</a></li>
                </ul>
            </nav>

            {{-- Header Actions --}}
            <div class="header-actions">
                <a href="#" title="Yêu thích">
                    <i class="bi bi-heart"></i>
                    <span class="icon-badge">0</span>
                </a>
@php
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
@endphp

<a href="{{ route('client.cart') }}" title="Giỏ hàng">
    <i class="bi bi-bag"></i>
    <span class="icon-badge">{{ $cartCount }}</span>
</a>

                
@if(Auth::guard('customer')->check())
    {{-- ĐÃ ĐĂNG NHẬP --}}
    <a href="{{ route('client.account') }}" title="Tài khoản">
        <i class="bi bi-person"></i>
    </a>
@else
    {{-- CHƯA ĐĂNG NHẬP --}}
    <a href="{{ route('client.login') }}" title="Đăng nhập">
        <i class="bi bi-person"></i>
    </a>
@endif

                <button class="mobile-toggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>

        </div>
    </header>

    {{-- ===========================
         INFO BAR
    ============================ --}}
    <div class="info-bar">
        <div class="info-bar-container">
<div class="info-item menu-tab">
    <i class="bi bi-shop"></i>
    <a href="{{ route('client.store-system') }}">
        Hệ thống cửa hàng
    </a>
</div>

            <div class="info-item menu-tab">
                <i class="bi bi-truck"></i>
                <a href="{{ route('client.shipping-policy') }}">
                    Thông tin vận chuyển
                </a>
            </div>
            <div class="info-item">
                <i class="bi bi-card-checklist"></i>
                <span>Chính sách tích điểm</span>
            </div>
        </div>
    </div>



    {{-- ===========================
         MAIN CONTENT
    ============================ --}}
    <main>
        @yield('content')
    </main>

<!-- CHAT ICON -->
    <div id="chat-icon">💬</div>

    <!-- CHAT BOX -->
    <div id="chat-box">
        <!-- Header -->
        <div class="chat-header">
            <div class="chat-avatar">🤖</div>
            <div class="chat-info">
                <h4>SWEETIE Support</h4>
                <p><span class="online-dot"></span>Đang hoạt động</p>
            </div>
            <button id="chat-close">×</button>
        </div>

        <!-- Body -->
        <div class="chat-body" id="chat-body">
            <div class="message bot">
                <div class="message-avatar">🤖</div>
                <div class="message-content">
                    <div class="message-bubble">
                        Xin chào! 👋 Tôi là trợ lý ảo của SWEETIE. Tôi có thể giúp gì cho bạn hôm nay?
                    </div>
                    <div class="message-time">Vừa xong</div>
                </div>
            </div>

            <div class="quick-replies">
                <button class="quick-reply-btn" onclick="sendQuickReply('Kiểm tra đơn hàng')">📦 Kiểm tra đơn hàng</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Chính sách đổi trả')">🔄 Chính sách đổi trả</button>
                <button class="quick-reply-btn" onclick="sendQuickReply('Liên hệ hỗ trợ')">💬 Liên hệ hỗ trợ</button>
            </div>

            <div class="typing-indicator" id="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn...">
            <button id="chat-send"><i class="bi bi-send-fill"></i></button>
        </div>
    </div>


    {{-- ===========================
         FOOTER
    ============================ --}}
    <footer>
        <div class="footer-container">

            <div class="footer-grid">

                {{-- Column 1 --}}
                <div>
                    <h5>Giới thiệu</h5>
                    <ul>
                        <li><a href="#">Về SWEETIE</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Hệ thống cửa hàng</a></li>
                    </ul>
                </div>

                {{-- Column 2 --}}
                <div>
                    <h5>Dịch vụ khách hàng</h5>
                    <ul>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách vận chuyển</a></li>
                        <li><a href="#">Chính sách thanh toán</a></li>
                    </ul>
                </div>

                {{-- Column 3 --}}
                <div>
                    <h5>Liên hệ với chúng tôi</h5>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Youtube</a></li>
                        <li><a href="#">Tiktok</a></li>
                    </ul>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                {{-- Column 4 --}}
                <div>
                    <h5>Đăng ký nhận tin</h5>
                    <p style="font-size: 13px; margin-bottom: 10px;">Nhận thông tin khuyến mãi & bộ sưu tập mới</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Email của bạn">
                        <button type="submit">Gửi</button>
                    </form>
                    <a href="#" class="dmca-badge">
                        <img src="https://images.dmca.com/Badges/dmca_protected_sml_120m.png" alt="DMCA Protected" width="100">
                    </a>
                </div>

            </div>

            {{-- Footer Bottom --}}
            <div class="footer-bottom">
                <p>© 2025 Công ty TNHH Thời Trang GMoon. All rights reserved.</p>
                <p style="margin-top: 5px;">MST: 0123456789 | Địa chỉ: Hà Nội, Việt Nam</p>
            </div>

        </div>
    </footer>

    {{-- ===========================
         JAVASCRIPT
    ============================ --}}
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
const chatIcon = document.getElementById('chat-icon');
const chatBox = document.getElementById('chat-box');
const chatClose = document.getElementById('chat-close');
const chatSend = document.getElementById('chat-send');
const chatInput = document.getElementById('chat-input');
const chatBody = document.getElementById('chat-body');
const typingIndicator = document.getElementById('typing-indicator');

// Toggle chat
chatIcon.onclick = () => {
    chatBox.classList.add('show');
    chatInput.focus();
};

chatClose.onclick = () => {
    chatBox.classList.remove('show');
};

// Send message
chatSend.onclick = sendMessage;
chatInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
        e.preventDefault();
        sendMessage();
    }
});

function sendMessage() {
    const text = chatInput.value.trim();
    if (!text) return;

    // 1. Hiện tin nhắn user
    addMessage(text, 'user');
    chatInput.value = '';

    // 2. Hiện typing indicator
    typingIndicator.style.display = 'block';
    scrollToBottom();

    // 3. Gọi API
fetch('{{ route("chatbot.suggest") }}', {
  method: 'POST',
  credentials: 'same-origin',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({ message: text })
})

.then(async (res) => {
  const contentType = res.headers.get('content-type') || '';
  let data;

  if (contentType.includes('application/json')) {
    data = await res.json();
  } else {
    const text = await res.text();
    throw new Error('Server trả về không phải JSON: ' + text.slice(0, 200));
  }

  if (!res.ok) {
    throw new Error(data.text || data.message || 'Server error');
  }

  return data;
})

    .then(data => {
        typingIndicator.style.display = 'none';

        console.log('✅ Response:', data); // Debug log

        // 4. Hiện tin nhắn bot
        if (data.text) {
            addMessage(data.text, 'bot');
        }

        // 5. Hiện sản phẩm (nếu có)
        if (data.products && Array.isArray(data.products) && data.products.length > 0) {
            addProductList(data.products);
        } else if (data.products && data.products.length === 0 && data.text.includes('tìm được')) {
            // Không làm gì, đã có message text rồi
        }

        scrollToBottom();
    })
    .catch(err => {
        typingIndicator.style.display = 'none';
        console.error('❌ Error:', err);
        
        addErrorMessage('Xin lỗi, hệ thống đang gặp sự cố. Vui lòng thử lại sau hoặc liên hệ hotline: 1900-xxxx');
        scrollToBottom();
    });
}

// Quick reply
function sendQuickReply(text) {
    chatInput.value = text;
    sendMessage();
}

// Thêm text message
function addMessage(text, sender) {
    const time = new Date().toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });

    const messageHTML = `
        <div class="message ${sender}">
            <div class="message-avatar">${sender === 'bot' ? '🤖' : '👤'}</div>
            <div class="message-content">
                <div class="message-bubble">${escapeHtml(text)}</div>
                <div class="message-time">${time}</div>
            </div>
        </div>
    `;

    typingIndicator.insertAdjacentHTML('beforebegin', messageHTML);
}

// Thêm danh sách sản phẩm
function addProductList(products) {
    const time = new Date().toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });

    products.forEach(product => {
        const productHTML = `
            <div class="message bot">
                <div class="message-avatar">🛍️</div>
                <div class="message-content">
                    <div class="product-card">
                        <img src="${product.image}" 
                             alt="${escapeHtml(product.name)}"
                             onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                        <div class="product-info">
                            <div class="product-name">${escapeHtml(product.name)}</div>
                            <div class="product-price">${product.price}</div>
                            <a href="${product.link}" 
                               class="product-link"
                               target="_blank">
                                Xem chi tiết →
                            </a>
                        </div>
                    </div>
                    <div class="message-time">${time}</div>
                </div>
            </div>
        `;

        typingIndicator.insertAdjacentHTML('beforebegin', productHTML);
    });
}

// Thêm error message
function addErrorMessage(text) {
    const time = new Date().toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });

    const errorHTML = `
        <div class="message bot">
            <div class="message-avatar">⚠️</div>
            <div class="message-content">
                <div class="message-bubble">
                    <div class="error-message">${escapeHtml(text)}</div>
                </div>
                <div class="message-time">${time}</div>
            </div>
        </div>
    `;

    typingIndicator.insertAdjacentHTML('beforebegin', errorHTML);
}

// Escape HTML để tránh XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Scroll to bottom
function scrollToBottom() {
    setTimeout(() => {
        chatBody.scrollTop = chatBody.scrollHeight;
    }, 100);
}
</script>

    @stack('js')
</body>
</html>