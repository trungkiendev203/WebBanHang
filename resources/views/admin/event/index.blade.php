@extends('admin.layouts.master')

@section('content')
<h3>Quản lý sự kiện</h3>

<a href="{{ route('admin.event.create') }}" class="btn btn-primary mb-3">
    + Thêm sự kiện
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tiêu đề</th>
            <th>Thời gian</th>
            <th>Vị trí</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $event)
        <tr>
            <td>{{ $event->id_event }}</td>
            <td>
                <b>{{ $event->title }}</b><br>
                <small>{{ $event->badge_text }}</small>
            </td>
            <td>
                {{ $event->start_date }} <br> → {{ $event->end_date }}
            </td>
            <td>{{ $event->position }}</td>
            <td>
                @if($event->status)
                    <span class="badge bg-success">Đang chạy</span>
                @else
                    <span class="badge bg-secondary">Tắt</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.event.edit', $event->id_event) }}" class="btn btn-sm btn-warning">Sửa</a>

                <form action="{{ route('admin.event.toggle', $event->id_event) }}"
                      method="POST" style="display:inline">
                    @csrf
                    <button class="btn btn-sm btn-dark">
                        {{ $event->status ? 'Tắt' : 'Bật' }}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
