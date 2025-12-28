@extends('admin.layouts.master')

@section('title','Bộ sưu tập')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Bộ sưu tập</h4>
        <a href="{{ route('admin.collection.create') }}" class="btn btn-primary">
            + Thêm mới
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td width="120">
                        @if($item->banner)
                            <img src="{{ asset('uploads/collections/'.$item->banner) }}" width="100">
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        {!! $item->status
                            ? '<span class="badge bg-success">Hiển thị</span>'
                            : '<span class="badge bg-secondary">Ẩn</span>' !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $collections->links() }}
    </div>
</div>
@endsection
