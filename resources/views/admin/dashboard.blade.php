@extends('admin.layouts.master')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="row">
  <div class="col-md-12 mb-4">
    <h4>Xin chào, {{ session('admin_login')->name_user }}</h4>
    <p>Chào mừng quay lại hệ thống quản trị!</p>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h5 class="card-title"><i class="fa-solid fa-box me-2"></i>Sản phẩm mới nhất</h5>
        <table class="table table-hover mt-3">
          <thead><tr><th>Tên</th><th>Giá</th></tr></thead>
          <tbody>
            @foreach($products as $p)
              <tr><td>{{ $p->name_product }}</td><td>{{ number_format($p->price_product) }}₫</td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
