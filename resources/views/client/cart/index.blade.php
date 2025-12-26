@extends('client.layouts.master')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">GIỎ HÀNG CỦA BẠN</h2>

    @if (empty($cart))
        <div class="alert alert-info text-center">
            Giỏ hàng của bạn đang trống.
        </div>
    @else
        <div class="row">
            <!-- CART LIST -->
            <div class="col-lg-8">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Thông tin</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Giá tiền</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $total = 0; @endphp

                        @foreach ($cart as $variantId => $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <!-- IMAGE -->
                                <td style="width:100px">
                                    <img src="{{ asset('uploads/product/' . $item['image']) }}"
                                         class="img-fluid rounded">
                                </td>

                                <!-- INFO -->
                                <td>
                                    <strong>{{ $item['name'] }}</strong><br>
                                    <small>{{ $item['color'] }} - {{ $item['size'] }}</small>
                                </td>

                                <!-- QUANTITY -->
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="updateQty({{ $variantId }}, -1)">−</button>

                                        <span style="min-width:20px; display:inline-block">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                onclick="updateQty({{ $variantId }}, 1)">+</button>
                                    </div>
                                </td>

                                <!-- PRICE -->
                                <td class="text-end text-danger fw-bold">
                                    {{ number_format($subtotal) }}đ
                                </td>

                                <!-- DELETE -->
                                <td class="text-center">
                                    <form action="{{ route('client.cart.delete', $variantId) }}"
                                          method="POST"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger">
                                            ✕
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SUMMARY -->
            <div class="col-lg-4">
                <div class="border p-4 rounded">
                    <h5 class="mb-3">Tóm tắt đơn hàng</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <strong>{{ number_format($total) }}đ</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Giảm giá:</span>
                        <strong>0đ</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Tổng tiền:</span>
                        <span class="fw-bold text-danger fs-5">
                            {{ number_format($total) }}đ
                        </span>
                    </div>

<a href="{{ route('client.checkout') }}" class="btn btn-danger w-100 mb-2">
    TIẾN HÀNH ĐẶT HÀNG
</a>


                    <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                        MUA THÊM SẢN PHẨM
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
function updateQty(variantId, change) {
    fetch("{{ route('client.cart.update') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            variant_id: variantId,
            change: change
        })
    }).then(() => location.reload());
}
</script>
@endpush
