@extends('layouts.admin_base')

@section('title', '予約編集')

@section('page_breadcrumb')

<h1 class="h4 fw-bold mb-4">予約編集 #{{ $reservation->id }}</h1>

@endsection

@section('content')

<form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">宿泊日</label>
        <input type="date" name="check_in" class="form-control"
            value="{{ \Carbon\Carbon::parse($reservation->check_in)->format('Y-m-d') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">人数</label>
        <input type="number" name="guests" class="form-control"
            value="{{ $reservation->guests }}" min="1" max="4">
    </div>

    <div class="mb-3">
        <label class="form-label">料金</label>
        <input type="number" name="total_price" class="form-control"
            value="{{ $reservation->total_price }}" min="0">
    </div>

    <div class="mb-3">
        <label class="form-label">状態</label>
        <select name="status" class="form-select">
            <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>確定</option>
            <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>キャンセル</option>
        </select>
    </div>

    <div class="d-flex gap-3">
        <button type="submit" class="btn btn-primary btn-update-w">更新</button>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary btn-cancel-w">一覧へ戻る</a>
    </div>
</form>
@endsection