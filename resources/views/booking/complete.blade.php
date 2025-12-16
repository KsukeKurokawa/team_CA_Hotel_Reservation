@extends('layouts.booking')

@section('content')
<div class="max-w-screen-md mx-auto p-6 text-center">
    <h1 class="text-2xl font-bold text-green-600 mb-4">予約が完了しました！</h1>

    @if(session('booking'))
        <div class="bg-white shadow rounded p-6 text-left">
            <p><strong>予約ID:</strong> booking-{{ session('booking.id') }}</p>
            <p><strong>部屋タイプ:</strong> {{ session('booking.room_name') }}</p>
            <p><strong>チェックイン:</strong> {{ session('booking.check_in') }}</p>
            <p><strong>チェックアウト:</strong> {{ session('booking.check_out_date') }}</p>
            <p><strong>人数:</strong> {{ session('booking.guests') }}名</p>
            <p><strong>料金:</strong> ¥{{ number_format(session('booking.total_price')) }}</p>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('booking.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            予約一覧へ戻る
        </a>
    </div>
</div>
@endsection

