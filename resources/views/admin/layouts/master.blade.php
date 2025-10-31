<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Trang quản trị')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #667eea;
      --secondary-color: #764ba2;
      --sidebar-bg: #1e1e2d;
      --sidebar-hover: #27293d;
      --text-dark: #1d3557;
      --text-light: #6c757d;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 260px;
      background: var(--sidebar-bg);
      color: white;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      padding: 0;
      box-shadow: 4px 0 20px rgba(0,0,0,0.1);
      overflow-y: auto;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: rgba(255,255,255,0.05);
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.2);
      border-radius: 3px;
    }

    .sidebar-header {
      padding: 2rem 1.5rem;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .sidebar-logo {
      width: 45px;
      height: 45px;
      background: white;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: var(--primary-color);
      font-weight: bold;
    }

    .sidebar-brand {
      flex: 1;
    }

    .sidebar-brand h4 {
      margin: 0;
      font-size: 20px;
      font-weight: 600;
    }

    .sidebar-brand p {
      margin: 0;
      font-size: 12px;
      opacity: 0.9;
    }

    .sidebar-menu {
      padding: 1rem 0;
    }

    .menu-section {
      margin-bottom: 1.5rem;
    }

    .menu-section-title {
      padding: 0.75rem 1.5rem;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: rgba(255,255,255,0.5);
    }

    .sidebar a {
      color: rgba(255,255,255,0.8);
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: 0.875rem 1.5rem;
      transition: all 0.3s ease;
      position: relative;
      gap: 1rem;
    }

    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 4px;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      transform: scaleY(0);
      transition: transform 0.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: var(--sidebar-hover);
      color: white;
    }

    .sidebar a.active::before {
      transform: scaleY(1);
    }

    .sidebar a i {
      font-size: 18px;
      width: 20px;
      text-align: center;
    }

    .menu-text {
      flex: 1;
      font-size: 14px;
      font-weight: 500;
    }

    .menu-badge {
      background: #dc3545;
      color: white;
      padding: 0.15rem 0.5rem;
      border-radius: 10px;
      font-size: 11px;
      font-weight: 600;
    }

    /* Content Area */
    .content {
      margin-left: 260px;
      min-height: 100vh;
      transition: all 0.3s ease;
    }

    /* Top Navbar */
    .navbar-admin {
      background: white;
      border-bottom: 1px solid rgba(0,0,0,0.08);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .navbar-left {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .menu-toggle {
      display: none;
      background: transparent;
      border: none;
      font-size: 24px;
      color: var(--text-dark);
      cursor: pointer;
    }

    .navbar-title {
      margin: 0;
      font-size: 24px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .navbar-right {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .navbar-search {
      position: relative;
      display: flex;
      align-items: center;
    }

    .navbar-search input {
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 0.5rem 1rem 0.5rem 2.5rem;
      width: 250px;
      transition: all 0.3s;
      font-size: 14px;
    }

    .navbar-search input:focus {
      outline: none;
      border-color: var(--primary-color);
      width: 300px;
    }

    .navbar-search i {
      position: absolute;
      left: 1rem;
      color: var(--text-light);
    }

    .navbar-notifications {
      position: relative;
      cursor: pointer;
      padding: 0.5rem;
    }

    .notification-icon {
      font-size: 20px;
      color: var(--text-dark);
    }

    .notification-badge {
      position: absolute;
      top: 0;
      right: 0;
      background: #dc3545;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    .admin-profile {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      cursor: pointer;
      padding: 0.5rem 1rem;
      border-radius: 10px;
      transition: background 0.3s;
    }

    .admin-profile:hover {
      background: #f8f9fa;
    }

    .admin-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 16px;
    }

    .admin-info {
      display: flex;
      flex-direction: column;
    }

    .admin-name {
      font-weight: 600;
      color: var(--text-dark);
      font-size: 14px;
      line-height: 1.2;
    }

    .admin-role {
      font-size: 12px;
      color: var(--text-light);
    }

    .btn-logout {
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      color: white;
      border: none;
      padding: 0.5rem 1.25rem;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-logout:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
    }

    /* Main Content */
    .main-content {
      padding: 2rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
      }

      .menu-toggle {
        display: block;
      }

      .navbar-search input {
        width: 150px;
      }

      .navbar-search input:focus {
        width: 200px;
      }

      .admin-info {
        display: none;
      }
    }

    @media (max-width: 576px) {
      .navbar-admin {
        padding: 1rem;
      }

      .navbar-title {
        font-size: 18px;
      }

      .navbar-search {
        display: none;
      }

      .main-content {
        padding: 1rem;
      }
    }

    /* Overlay for mobile */
    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }

    .sidebar-overlay.active {
      display: block;
    }
  </style>
</head>
<body>

  {{-- Sidebar Overlay --}}
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  {{-- Sidebar --}}
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo">
        <i class="fas fa-store"></i>
      </div>
      <div class="sidebar-brand">
        <h4>Admin Panel</h4>
        <p>Quản trị cửa hàng</p>
      </div>
    </div>

    <div class="sidebar-menu">
      <div class="menu-section">
        <div class="menu-section-title">Tổng quan</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
          <i class="fas fa-chart-line"></i>
          <span class="menu-text">Thống kê</span>
        </a>
        <a href="#">
          <i class="fas fa-chart-pie"></i>
          <span class="menu-text">Báo cáo</span>
        </a>
      </div>

      <div class="menu-section">
        <div class="menu-section-title">Quản lý</div>
        <a href="#">
          <i class="fas fa-box-open"></i>
          <span class="menu-text">Sản phẩm</span>
          <span class="menu-badge">{{ $products->count() ?? 0 }}</span>
        </a>
        <a href="#">
          <i class="fas fa-layer-group"></i>
          <span class="menu-text">Loại sản phẩm</span>
        </a>
        <a href="#">
          <i class="fas fa-tags"></i>
          <span class="menu-text">Hiệu sản phẩm</span>
        </a>
        <a href="#">
          <i class="fas fa-palette"></i>
          <span class="menu-text">Màu sản phẩm</span>
        </a>
      </div>

      <div class="menu-section">
        <div class="menu-section-title">Bán hàng</div>
        <a href="#">
          <i class="fas fa-file-invoice"></i>
          <span class="menu-text">Đơn hàng</span>
        </a>
        <a href="#">
          <i class="fas fa-receipt"></i>
          <span class="menu-text">Đặt hàng</span>
        </a>
        <a href="#">
          <i class="fas fa-truck"></i>
          <span class="menu-text">Giao hàng</span>
        </a>
        <a href="#">
          <i class="fas fa-file-invoice-dollar"></i>
          <span class="menu-text">Hóa đơn</span>
        </a>
      </div>

      <div class="menu-section">
        <div class="menu-section-title">Khác</div>
        <a href="#">
          <i class="fas fa-list"></i>
          <span class="menu-text">Danh sách</span>
        </a>
        <a href="#">
          <i class="fas fa-bullhorn"></i>
          <span class="menu-text">Quảng cáo</span>
        </a>
        <a href="#">
          <i class="fas fa-bookmark"></i>
          <span class="menu-text">Tính thành</span>
        </a>
        <a href="#">
          <i class="fas fa-envelope"></i>
          <span class="menu-text">Liên hệ</span>
        </a>
      </div>
    </div>
  </div>

  {{-- Main Content --}}
  <div class="content">
    <div class="navbar-admin">
      <div class="navbar-left">
        <button class="menu-toggle" id="menuToggle">
          <i class="fas fa-bars"></i>
        </button>
        <h5 class="navbar-title">@yield('title', 'Dashboard')</h5>
      </div>

      <div class="navbar-right">
        <div class="navbar-search">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Tìm kiếm...">
        </div>

        <div class="navbar-notifications">
          <i class="fas fa-bell notification-icon"></i>
          <span class="notification-badge">5</span>
        </div>

        <div class="admin-profile">
          <div class="admin-avatar">
            {{ strtoupper(substr(session('admin_login')->name_user ?? 'A', 0, 1)) }}
          </div>
          <div class="admin-info">
            <span class="admin-name">{{ session('admin_login')->name_user ?? 'Admin' }}</span>
            <span class="admin-role">Quản trị viên</span>
          </div>
        </div>

        <a href="{{ route('admin.logout') }}" class="btn-logout">
          <i class="fas fa-sign-out-alt"></i>
          <span>Đăng xuất</span>
        </a>
      </div>
    </div>

    <div class="main-content">
      @yield('content')
    </div>
  </div>

  <script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      sidebarOverlay.classList.toggle('active');
    });

    sidebarOverlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      sidebarOverlay.classList.remove('active');
    });

    // Close sidebar on window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth > 992) {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>