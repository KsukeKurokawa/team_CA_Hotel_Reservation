@extends('layouts.booking')

@section('content')
<div class="max-w-screen-2xl mx-auto p-6">

    <!-- タブナビゲーション -->
    <ul class="nav nav-tabs" id="bookingTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab">
          予約フォーム
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">
          予約一覧
        </button>
      </li>
    </ul>

    <!-- タブコンテンツ -->
    <div class="tab-content mt-4" id="bookingTabsContent">

      <!-- 予約フォーム -->
      <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
        <h1 class="text-xl font-bold">一泊限定 高級宿泊施設予約</h1>
        <p class="text-gray-600">
          @if(auth()->check())
              ようこそ、{{ Auth::user()->name }}様
          @else
              ようこそ、ゲスト様
          @endif
        </p>

        {{-- 予約フォーム全体 --}}
        <form action="{{ route('booking.store') }}" method="POST" class="mt-6 grid grid-cols-2 gap-6">
            @csrf

            {{-- 左サイドバー --}}
            <div class="bg-white p-4 rounded shadow">

                {{-- チェックイン日選択 --}}
                <label for="check_in_date">チェックイン日</label>
                <input type="date" id="check_in_date"
                       value="{{ request('check_in_date') ?? now()->format('Y-m-d')}}"
                       onchange="window.location='{{ route('booking.create') }}?check_in_date='+this.value"
                       class="border p-2 w-full">

                {{-- hiddenで選択日を保持（予約確定時に送信される） --}}
                <input type="hidden" name="check_in_date" value="{{ request('check_in_date') ?? now()->format('Y-m-d') }}">

                {{-- 人数入力 --}}
                <label class="mt-4">人数
                    <input type="number" name="guest_count" value="2" min="1" class="border p-2 w-full">
                </label>

                {{-- プラン選択 --}}
                <label class="mt-4">プラン
                  <div>
                      <input type="checkbox" name="selected_plans[]" value="breakfast"> 朝食付き (+3000円/人)
                  </div>
                </label>
                
                {{-- 予約確定ボタン(初期は白文字＋disabled) --}}
                <button type="submit" class="mt-6 bg-amber-600 text-white px-4 py-2 rounded"
                        id="reserveBtn" disabled>
                    予約確定
                </button>
            </div>

            {{-- 右メインエリア --}}
            <div class="grid grid-cols-1 gap-4">
                @foreach($rooms as $room)
                    <div class="border rounded p-4 {{ !$room->available ? 'opacity-50' : '' }}">
                        <h2 class="text-lg font-bold mt-2">{{ $room->type_name }}</h2>
                        <p>料金: ¥{{ number_format($room->price) }}</p>
                        <p>残り部屋数: {{ $room->remaining_rooms }} / {{ $room->total_rooms }}</p>
                        <label>
                            <input type="radio" name="room_id" value="{{ $room->id }}"
                                   {{ !$room->available ? 'disabled' : '' }}
                                   onchange="enableReserveBtn()">
                            {{ $room->available ? '選択可能' : '満室' }}
                        </label>
                    </div>
                @endforeach
            </div>
        </form>
      </div>

      <!-- 予約一覧 -->
      <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
        @if($reservations->isEmpty())
            <p>現在、予約はありません。</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">予約ID</th>
                        <th class="border px-4 py-2">部屋タイプ</th>
                        <th class="border px-4 py-2">チェックイン</th>
                        <th class="border px-4 py-2">人数</th>
                        <th class="border px-4 py-2">料金</th>
                        <th class="border px-4 py-2">ステータス</th>
                        <th class="border px-4 py-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="border px-4 py-2">booking-{{ $reservation->id }}</td>
                            <td class="border px-4 py-2">{{ $reservation->room->type_name }}</td>
                            <td class="border px-4 py-2">{{ $reservation->check_in->format('Y-m-d') }}</td>
                            <td class="border px-4 py-2">{{ $reservation->guests }}名</td>
                            <td class="border px-4 py-2">¥{{ number_format($reservation->total_price) }}</td>
                            <td class="border px-4 py-2">
                                @if($reservation->status === 'confirmed')
                                    <span class="text-green-600">確定</span>
                                @else
                                    <span class="text-red-600">キャンセル済み</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if($reservation->status === 'confirmed')
                                    <form action="{{ route('booking.cancel', $reservation->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('本当にキャンセルしますか？')" class="bg-red-500 text-white px-3 py-1 rounded">
                                           キャンセル
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
      </div>
    </div>
</div>

{{-- JavaScriptで予約ボタンを有効化＋文字色変更 --}}
<script>
function enableReserveBtn() {
    const btn = document.getElementById('reserveBtn');
    btn.disabled = false;               // ボタンを有効化
    btn.classList.remove('text-white'); // 白文字を削除
    btn.classList.add('text-black');    // 黒文字を追加
}
</script>
@endsection