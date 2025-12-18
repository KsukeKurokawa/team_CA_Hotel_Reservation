@extends('layouts.admin')
@section('content')

<h1>管理者用予約一覧</h1>

<form action="{{route('admin.reservations.index')}}" method="GET">
    <input type="text" name="date" placeholder="日付で検索">
    <button type="submit">検索</button>
</form>

@foreach($reservations as $date => $dailyReservations)
<h2>{{ $date }}</h2>
<table border="1" cellpadding="5">
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
                @if($reservation->status=== 'confirmed')
                確定
                @else
                キャンセル
                @endif
            </td>
            <td>
                <a href="{{ route('admin.reservations.edit', $reservation->id) }}">編集</a>
                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach

@endsection