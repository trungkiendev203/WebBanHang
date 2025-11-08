@extends('admin.layouts.master')
@section('title', 'Thêm hóa đơn')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="text-danger">Thêm hóa đơn mới</h5>
    </div>
    <div class="card-body">
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
        window.location.reload(); // tự reload lại trang
    </script>
@endif

@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif


        <form action="{{ route('admin.order.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <h6>Thông tin khách hàng</h6>
                    <input type="text" name="name_customer" class="form-control mb-2" placeholder="Họ và tên" required>
                    <input type="email" name="email_customer" class="form-control mb-2" placeholder="Email (không bắt buộc)">
                    <input type="text" name="phone_customer" class="form-control mb-2" placeholder="Số điện thoại" required>
                </div>
<div class="col-md-6">
    <h6>Địa chỉ giao hàng</h6>
    <select id="province" name="province" class="form-select mb-2" required>
        <option value="">-- Chọn Tỉnh/Thành phố --</option>
    </select>

    <select id="district" name="district" class="form-select mb-2" required>
        <option value="">-- Chọn Quận/Huyện --</option>
    </select>

    <select id="ward" name="ward" class="form-select mb-2" required>
        <option value="">-- Chọn Phường/Xã --</option>
    </select>

    <input type="text" name="address_detail" class="form-control" placeholder="Số nhà, tên đường">
</div>

            </div>

            <hr>

            <h6>Chọn sản phẩm</h6>
            <input type="text" id="search_product" class="form-control mb-3" placeholder="Gõ mã hoặc tên sản phẩm">

            <table class="table table-bordered" id="table_product">
                <thead class="table-light">
                    <tr>
                        <th>STT</th><th>Mã SP</th><th>Tên SP</th><th>Giá</th><th>Số lượng</th><th>Tổng</th><th>Xóa</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div class="text-end">
                <button class="btn btn-primary">Tạo đơn hàng</button>
            </div>
        </form>
    </div>
</div>

<script>
let products = @json($products);
let count = 0;
let tbody = document.querySelector('#table_product tbody');
let search = document.querySelector('#search_product');

search.addEventListener('change', () => {
    let keyword = search.value.toLowerCase();
    let product = products.find(p => p.name_product.toLowerCase().includes(keyword) || p.code_product.toLowerCase().includes(keyword));
    if (!product) return alert('Không tìm thấy sản phẩm!');
    addProduct(product);
    search.value = '';
});

function addProduct(p) {
    count++;
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${count}</td>
        <td>${p.code_product}<input type="hidden" name="products[${count}][id]" value="${p.id_product}"></td>
        <td>${p.name_product}</td>
        <td>${p.saleprice_product.toLocaleString()} đ</td>
        <td><input type="number" name="products[${count}][quantity]" value="1" min="1" class="form-control form-control-sm" onchange="updateTotal(this)"></td>
        <td class="subtotal">${p.saleprice_product.toLocaleString()} đ</td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button></td>
    `;
    tbody.appendChild(tr);
}

function updateTotal(input) {
    let tr = input.closest('tr');
    let price = parseFloat(tr.cells[3].innerText.replace(/[^\d]/g, ''));
    let qty = parseInt(input.value);
    tr.querySelector('.subtotal').innerText = (price * qty).toLocaleString() + ' đ';
}
const API_BASE = "https://provinces.open-api.vn/api";

const provinceSelect = document.getElementById('province');
const districtSelect = document.getElementById('district');
const wardSelect = document.getElementById('ward');

// 1. Load danh sách tỉnh thành
fetch(`${API_BASE}/p/`)
  .then(res => res.json())
  .then(provinces => {
    provinces.forEach(p => {
      const opt = document.createElement('option');
      opt.value = p.code; // code của tỉnh
      opt.textContent = p.name;
      provinceSelect.appendChild(opt);
    });
  });

// 2. Khi chọn tỉnh → load quận huyện
provinceSelect.addEventListener('change', () => {
  const provinceCode = provinceSelect.value;
  districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
  wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';

  if (!provinceCode) return;

  fetch(`${API_BASE}/p/${provinceCode}?depth=2`)
    .then(res => res.json())
    .then(data => {
      if (data.districts) {
        data.districts.forEach(d => {
          const opt = document.createElement('option');
          opt.value = d.code;
          opt.textContent = d.name;
          districtSelect.appendChild(opt);
        });
      }
    });
});

// 3. Khi chọn quận → load phường
districtSelect.addEventListener('change', () => {
  const districtCode = districtSelect.value;
  wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';

  if (!districtCode) return;

  fetch(`${API_BASE}/d/${districtCode}?depth=2`)
    .then(res => res.json())
    .then(data => {
      if (data.wards) {
        data.wards.forEach(w => {
          const opt = document.createElement('option');
          opt.value = w.name;
          opt.textContent = w.name;
          wardSelect.appendChild(opt);
        });
      }
    });
});
</script>
@endsection
