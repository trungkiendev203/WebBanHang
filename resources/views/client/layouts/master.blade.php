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
                    <li class="nav-item">
                        <a href="#">
                            BLACK FRIDAY
                            <span class="sale-badge">SALE</span>
                        </a>
                    </li>
                    <li><a href="{{ route('client.category', 'dam-cong-so') }}">ĐẦM</a></li>
                    <li><a href="{{ route('client.category', 'ao') }}">ÁO</a></li>
                    <li><a href="{{ route('client.category', 'quan') }}">QUẦN</a></li>
                    <li><a href="{{ route('client.category', 'chan-vay') }}">CHÂN VÁY</a></li>
                    <li><a href="{{ route('client.category', 'ao-khoac') }}">ÁO KHOÁC</a></li>
                    <li><a href="#">LOOKBOOK</a></li>
                    <li><a href="#">BST MỚI</a></li>
                </ul>
            </nav>

            {{-- Header Actions --}}
            <div class="header-actions">
                <a href="#" title="Yêu thích">
                    <i class="bi bi-heart"></i>
                    <span class="icon-badge">0</span>
                </a>
                <a href="{{ route('client.cart') }}" title="Giỏ hàng">
                    <i class="bi bi-bag"></i>
                    <span class="icon-badge">0</span>
                </a>
                <a href="#" title="Tài khoản">
                    <i class="bi bi-person"></i>
                </a>
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
                        <li><a href="#">Về GMoon</a></li>
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

    @stack('js')
</body>
</html>