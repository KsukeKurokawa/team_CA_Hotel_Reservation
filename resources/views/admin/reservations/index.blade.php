@extends('layouts.admin_base')

@section('title', '予約一覧')

@section('page_breadcrumb')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 w-100">

    {{-- 左側：タイトル --}}
    <h1 class="h4 fw-bold m-0">管理者用予約一覧</h1>

    {{-- 右側：検索フォーム --}}
    <form action="{{ route('admin.reservations.index') }}" method="GET"
        class="d-flex gap-2 mt-2 mt-md-0 ms-md-auto">
        <input type="text" name="date"
            class="form-control"
            style="width: 260px;"
            placeholder="日付で検索 (例: 2025-12-30)">
        <button type="submit" class="btn btn-primary">検索</button>
    </form>

</div>
@endsection

@section('content')

@foreach($reservations as $date => $dailyReservations)
<h2 class="h5 fw-bold mt-4">{{ $date }}</h2>

<div class="table-responsive">
    <table class="table table-dark table-striped table-sm align-middle">
        <thead>
            <tr>
                <th class="text-nowrap">部屋名</th>
                <th class="text-nowrap">予約者名</th>
                <th class="text-nowrap">電話番号</th>
                <th class="text-nowrap">人数</th>
                <th class="text-nowrap">状態</th>
                <th class="text-nowrap">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyReservations as $reservation)
            <tr>
                <td class="text-nowrap">{{ $reservation->room->type_name }}</td>
                <td class="text-nowrap">{{ $reservation->user->name }}</td>
                <td class="text-nowrap">{{ $reservation->user->phone }}</td>
                <td class="text-nowrap">{{ $reservation->guests }}名</td>
                <td class="text-nowrap">
                    @if($reservation->status === 'confirmed')
                    <span class="badge bg-success">確定</span>
                    @else
                    <span class="badge bg-secondary">キャンセル</span>
                    @endif
                </td>
                <td class="text-nowrap">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                            class="btn btn-sm btn-primary">編集</a>

                        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">削除</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach
@endsection