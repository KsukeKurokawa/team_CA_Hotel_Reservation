@extends('layouts.app')

@section('content')
<div class="text-center mt-5">
    <h1 class="text-success fw-bold fs-2">予約が完了しました！</h1>
    <p class="fs-5 mt-3">ご予約ありがとうございます。詳細は予約一覧からご確認いただけます。</p>
    <a href="{{ route('booking.index') }}" class="btn btn-primary mt-4">予約一覧へ戻る</a>
</div>
@endsection
