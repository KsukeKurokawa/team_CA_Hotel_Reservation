@extends('layouts.admin_base')

@section('title', '予約一覧')

@section('page_breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">管理画面</a></li>
        <li class="breadcrumb-item active" aria-current="page">予約一覧</li>
    </ol>
</nav>
@endsection

@section('content')
<h1 class="h4 fw-bold mb-4">管理者用予約一覧</h1>


<form action="{{ route('admin.reservations.index') }}" method="GET" class="row g-3 mb-4">
    <div class="col-auto">
        <input type="text" name="date" class="form-control" placeholder="日付で検索 (例: 2025-12-30)">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">検索</button>
    </div>
</form>


@foreach($reservations as $date => $dailyReservations)
<h2 class="h5 fw-bold mt-4">{{ $date }}</h2>
<table class="table table-dark table-striped align-middle">
    <thead>
        <tr>
            <th>部屋名</th>
            <th>予約者名</th>
            <th>電話番号</th>
            <th>人数</th>
            <th>状態</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dailyReservations as $reservation)
        <tr>
            <td>{{ $reservation->room->type_name }}</td>
            <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->user->phone }}</td>
            <td>{{ $reservation->guests }}名</td>
            <td>
                @if($reservation->status === 'confirmed')
                <span class="badge bg-success">確定</span>
                @else
                <span class="badge bg-secondary">キャンセル</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="btn btn-sm btn-primary me-2">編集</a>
                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach
@endsection