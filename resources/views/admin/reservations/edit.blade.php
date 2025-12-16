@extends('layouts.admin')

@section('content')
<h1>予約編集#{{$reservation->id}}</h1>

<form action="{{route('admin.reservations.update',$reservation->id)}}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>宿泊日</label>
        <input type="date" name="check_in" value="{{$reservation->check_in}}">
    </div>
    <div>
        <label>人数</label>
        <input type="number" name="guests" value="{{$reservation->guests}}" min="1" max="4">
    </div>
    <div>
        <label>料金</label>
        <input type="number" name="total_price" value="{{$reservation->total_price}}" min="0">
    </div>
    <div>
        <label>状態</label>
        <select name="status">
            <option value="confirmed" {{$reservation->status==='confirmed' ? 'selected' : ''}}>確定</option>
            <option value="cancelled" {{$reservation->status==='cancelled' ? 'selected' : ''}}>キャンセル</option>
        </select>
    </div>
    <button type="submit">更新</button>
</form>
<p><a href="{{route('admin.reservations.index')}}">一覧へ戻る</a></p>
@endsection