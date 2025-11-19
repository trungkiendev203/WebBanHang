@extends('client.layouts.master')

@section('content')
<div class="container py-5">
    <h1>{{ $product->name_product }}</h1>
    <img src="{{ asset('uploads/product/' . $product->image) }}" width="300">
    <p>Giá: {{ number_format($product->price_product) }}đ</p>
</div>
@endsection
