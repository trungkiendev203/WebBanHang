<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập quản trị</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      padding: 40px;
      max-width: 420px;
      width: 100%;
      animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .login-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .login-icon svg {
      width: 40px;
      height: 40px;
      fill: white;
    }

    h3 {
      color: #333;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #666;
      font-size: 14px;
    }

    .form-label {
      color: #555;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-control {
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      padding: 12px 16px;
      transition: all 0.3s ease;
      font-size: 15px;
    }

    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
      transform: translateY(-2px);
    }

    .btn-login {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 10px;
      padding: 14px;
      font-weight: 600;
      font-size: 16px;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
      background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .alert {
      border-radius: 10px;
      border: none;
      animation: shake 0.5s;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      75% { transform: translateX(10px); }
    }

    .input-group {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #666;
      cursor: pointer;
      padding: 5px;
      z-index: 10;
    }

    .password-toggle:hover {
      color: #667eea;
    }

    .floating-shapes {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
      overflow: hidden;
      z-index: 0;
    }

    .shape {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 15s infinite;
    }

    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      left: 10%;
      top: 20%;
      animation-delay: 0s;
    }

    .shape:nth-child(2) {
      width: 120px;
      height: 120px;
      right: 15%;
      top: 40%;
      animation-delay: 2s;
    }

    .shape:nth-child(3) {
      width: 60px;
      height: 60px;
      left: 20%;
      bottom: 20%;
      animation-delay: 4s;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
      }
      50% {
        transform: translateY(-30px) rotate(180deg);
      }
    }
  </style>
</head>
<body>

<div class="floating-shapes">
  <div class="shape"></div>
  <div class="shape"></div>
  <div class="shape"></div>
</div>

<div class="login-container">
  <div class="login-header">
    <div class="login-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
      </svg>
    </div>
    <h3>Đăng nhập quản trị</h3>
    <p class="subtitle">Vui lòng nhập thông tin để tiếp tục</p>
  </div>

  @if(session('error'))
    <div class="alert alert-danger">
      <strong>⚠️ Lỗi!</strong> {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('admin.login.post') }}" method="POST">
    @csrf
    <div class="mb-4">
      <label class="form-label">Tài khoản</label>
      <input type="text" name="account_user" class="form-control" placeholder="Nhập tài khoản của bạn" required autofocus>
    </div>
    
    <div class="mb-4">
      <label class="form-label">Mật khẩu</label>
      <div class="input-group">
        <input type="password" name="pass_user" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
        <button type="button" class="password-toggle" onclick="togglePassword()">
          <span id="eye-icon">👁️</span>
        </button>
      </div>
    </div>
    
    <button type="submit" class="btn btn-login w-100">
      Đăng nhập
    </button>
  </form>
</div>

<script>
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIcon.textContent = '👁️‍🗨️';
    } else {
      passwordInput.type = 'password';
      eyeIcon.textContent = '👁️';
    }
  }
</script>

</body>
</html>