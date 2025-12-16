@extends('layouts.booking')

@section('content')
<div class="max-w-screen-2xl mx-auto p-6">
    <h1 class="text-xl font-bold">予約確認</h1>

    @foreach($reservations as $reservation)
        <div class="border rounded p-4 mt-4">
            <h2 class="font-bold">{{ $booking->room->name }}</h2>
            <p>チェックイン: {{ $booking->check_in_date->format('Y-m-d') }}</p>
            <p>チェックアウト: {{ $booking->check_out_date->format('Y-m-d') }}</p>
            <p>人数: {{ $booking->guest_count }} </p>
            <p>合計金額: {{ $booking->total_price }}円</p>

            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded">キャンセル</button>
            </form>
        </div>
    @endforeach
</div>
@endsection

