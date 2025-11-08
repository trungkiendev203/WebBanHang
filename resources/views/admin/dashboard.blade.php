@extends('admin.layouts.master')
@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Bảng điều khiển')

@section('content')
<div class="dashboard-header">
  <h2 class="mb-1"><i class="fas fa-chart-line me-2"></i>Thống kê cửa hàng</h2>
  <p class="text-muted">Tổng quan hoạt động kinh doanh</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-primary">
      <div class="stat-icon">
        <i class="fas fa-box"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-value">{{ $products->count() }}</h3>
        <p class="stat-label">Sản phẩm bán chạy</p>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-success">
      <div class="stat-icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-value">{{ array_sum($products->pluck('quantity_sold')->toArray()) }}</h3>
        <p class="stat-label">Đơn hàng đặt</p>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-warning">
      <div class="stat-icon">
        <i class="fas fa-eye"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-value">{{ array_sum($products->pluck('views')->toArray()) }}</h3>
        <p class="stat-label">Lượt xem</p>
      </div>
    </div>
  </div>
  
  <div class="col-xl-3 col-md-6">
    <div class="stat-card stat-card-info">
      <div class="stat-icon">
        <i class="fas fa-boxes"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-value">{{ $products->count() }}</h3>
        <p class="stat-label">Còn hàng</p>
      </div>
    </div>
  </div>
</div>

<!-- Best Selling Products -->
<div class="card modern-card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <i class="fas fa-fire text-danger me-2"></i>Sản phẩm bán chạy
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover modern-table mb-0">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th class="text-end">Giá</th>
            <th class="text-end">Giá bán</th>
            <th class="text-center">Số lượng</th>
            <th class="text-center">Lượt xem</th>
            <th class="text-center">Đã bán</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Xem</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $index => $p)
          <tr>
            <td><span class="badge bg-light text-dark">{{ $index + 1 }}</span></td>
            <td><span class="code-badge">{{ $p->code_product }}</span></td>
            <td>
              <div class="product-name">{{ $p->name_product }}</div>
            </td>
<td>
  <img 
    src="{{ Str::startsWith($p->image, 'http') 
            ? $p->image 
            : asset('uploads/product/'.$p->image) }}" 
    alt="{{ $p->name_product }}" 
    class="product-thumb">
</td>


            <td class="text-end">
              <span class="price-original">{{ number_format($p->price_product) }} ₫</span>
            </td>
            <td class="text-end">
              <span class="price-sale">{{ number_format($p->saleprice_product) }} ₫</span>
            </td>
            <td class="text-center">
              <span class="badge bg-info">{{ $p->quantity }}</span>
            </td>
            <td class="text-center">
              <span class="stat-badge stat-badge-warning">
                <i class="fas fa-eye"></i> {{ $p->view_product }}

              </span>
            </td>
            <td class="text-center">
              <span class="stat-badge stat-badge-success">
                <i class="fas fa-check"></i> {{ $p->quantity_sold }}
              </span>
            </td>
            <td class="text-center">
              <span class="badge badge-status badge-active">
                <i class="fas fa-check-circle"></i> Còn hàng
              </span>
            </td>
            <td class="text-center">
              <button class="btn btn-sm btn-view" title="Xem chi tiết">
                <i class="fas fa-eye"></i>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Revenue Chart Section -->
<div class="row g-4">
  <div class="col-lg-8">
    <div class="card modern-card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <i class="fas fa-chart-bar text-primary me-2"></i>Doanh thu
        </h5>
        <div class="chart-tabs">
          <button class="chart-tab active" data-period="year">Năm</button>
          <button class="chart-tab" data-period="month">Tháng trước</button>
          <button class="chart-tab" data-period="today">Tháng này</button>
          <button class="chart-tab" data-period="week">7 ngày qua</button>
        </div>
      </div>
      <div class="card-body">
        <canvas id="revenueChart" height="80"></canvas>
      </div>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="card modern-card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <i class="fas fa-chart-pie text-success me-2"></i>Kho
        </h5>
      </div>
      <div class="card-body">
        <canvas id="inventoryChart"></canvas>
      </div>
    </div>
  </div>
</div>
@php
    $labels = $monthlyRevenue->pluck('thang');
    $data = $monthlyRevenue->pluck('total');
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// === Revenue Chart (Doanh thu theo tháng) ===
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
  type: 'line',
  data: {
    labels: {!! json_encode($labels) !!}, // Tháng có doanh thu thật
    datasets: [{
      label: 'Doanh thu (VNĐ)',
      data: {!! json_encode($data) !!},
      borderColor: 'rgb(102, 126, 234)',
      backgroundColor: 'rgba(102, 126, 234, 0.1)',
      borderWidth: 3,
      fill: true,
      tension: 0.4,
      pointRadius: 4,
      pointHoverRadius: 6,
      pointBackgroundColor: 'white',
      pointBorderColor: 'rgb(102, 126, 234)',
      pointBorderWidth: 2
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: 'rgba(0,0,0,0.8)',
        padding: 12,
        borderRadius: 8,
        titleFont: { size: 14 },
        bodyFont: { size: 13 },
        callbacks: {
          label: function(context) {
            // Hiển thị doanh thu dạng 999.000 ₫
            return ' ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' ₫';
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        grid: { color: 'rgba(0,0,0,0.05)' },
        ticks: { 
          font: { size: 12 },
          callback: function(value) {
            return new Intl.NumberFormat('vi-VN').format(value);
          }
        }
      },
      x: {
        grid: { display: false },
        ticks: { font: { size: 12 } }
      }
    }
  }
});

// === Inventory Chart (giữ nguyên) ===
const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
const inventoryChart = new Chart(inventoryCtx, {
  type: 'doughnut',
  data: {
    labels: ['Còn hàng', 'Sắp hết', 'Hết hàng'],
    datasets: [{
      data: [65, 25, 10],
      backgroundColor: [
        'rgba(17, 153, 142, 0.8)',
        'rgba(245, 87, 108, 0.8)',
        'rgba(108, 117, 125, 0.8)'
      ],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: {
        position: 'bottom',
        labels: { padding: 15, font: { size: 13 } }
      }
    }
  }
});

// Chart tabs functionality
document.querySelectorAll('.chart-tab').forEach(tab => {
  tab.addEventListener('click', function() {
    document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>

@endsection