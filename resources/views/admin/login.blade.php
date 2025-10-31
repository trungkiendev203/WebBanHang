<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập quản trị</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:400px;">
  <h3 class="text-center mb-4">Đăng nhập quản trị</h3>

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <form action="{{ route('admin.login.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Tài khoản</label>
      <input type="text" name="account_user" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Mật khẩu</label>
      <input type="password" name="pass_user" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Đăng nhập</button>
  </form>
</div>

</body>
</html>
