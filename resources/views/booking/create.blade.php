@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto p-6">

<!-- タイトルとユーザー名 -->
        <h1 class="text-fs-4 font-bold">一泊限定 高級宿泊施設予約</h1>
        <p class="fs-5 text-muted">
          @if(auth()->check())
              ようこそ、{{ Auth::user()->name }}様
          @else
              ようこそ、ゲスト様
          @endif
        </p>

    <!-- タブナビゲーション -->
    <ul class="nav nav-tabs fs-5" id="bookingTabs" role="tablist">
      <li class="nav-item" role="presentation">
    <button class="nav-link active px-4 py-3" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab">
          予約フォーム
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link px-4 py-3" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">
          予約一覧
        </button>
      </li>
    </ul>

    <!-- タブコンテンツ -->
    <div class="tab-content mt-4" id="bookingTabsContent">

      <!-- 予約フォーム -->
      <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
        @if(session('booking'))
            <div class="bg-white p-5 rounded shadow text-center">
              <h2 class="text-success fw-bold fs-2">ご予約ありがとうございます。</h2>
              <p class="fs-5 mt-3">予約が完了しました。ご来館を心よりお待ちしております。</p>
              <!-- 予約情報を表示 -->
              <p><strong>予約ID：</strong> booking-{{ session('booking')['id'] }}</p>
              <p><strong>お部屋：</strong> {{ session('booking')['room_name'] }}</p>
              <p><strong>チェックイン：</strong> {{ session('booking')['check_in'] }}</p>
              <p><strong>チェックアウト：</strong> {{ session('booking')['check_out_date'] }}</p>
              <p><strong>宿泊人数：</strong> {{ session('booking')['guests'] }}名</p>
              <p class="fs-4 mt-3"><strong>総合料金：</strong> ¥{{ number_format(session('booking')['total_price']) }}</p>

              <a href="{{ route('booking.create') }}" class="btn btn-primary mt-4">閉じる</a>
            </div>
        @else

        {{-- 通常の予約フォーム --}}
        <form action="{{ route('booking.store') }}" method="POST" class="row g-4">
            @csrf
            {{-- 左サイドバー --}}
            <div class="col-md-3">

                 {{-- チェックイン日選択 --}}  
                <label for="check_in_date">チェックイン日</label>
                <input type="date" id="check_in_date"
                        value="{{ request('check_in_date') ?? now()->format('Y-m-d')}}"
                        onchange="window.location='{{ route('booking.create') }}?check_in_date='+this.value"
                        class="border p-2 w-full">

                {{-- hiddenで選択日を保持 --}}
                <input type="hidden" name="check_in_date" value="{{ request('check_in_date') ?? now()->format('Y-m-d') }}">

                {{-- 人数入力 --}}
                <label class="mt-4">人数
                    <input type="number" id ="guest_count" name="guest_count" value="2" min="1" max="4" class="border p-2 w-full" onchange="updateTotal()">
                </label>

                {{-- プラン選択 --}}
                <label class="mt-4">プラン
                  <div>
                      <input type="checkbox" name="selected_plans[]" value="breakfast" id="planBreakfast" oninput="updateTotal()"> 
                      <label for="planBreakfast">朝食付き (+3000円/人)</label>
                  </div>
                </label>
                
                {{-- 合計金額表示 --}}
                <div class="mt-5 mb-3 text-center">
                    <h2 class="fw-bold text-primary" id="totalPrice">合計金額: ¥0</h2>
                </div>

                {{-- 予約確定ボタン(部屋選択があれば有効) --}}
                <button type="submit" class="btn btn-warning btn-lg w-100"
                        id="reserveBtn" disabled>
                    予約確定
                </button>
            </div>

            {{-- 右メインエリア --}}
            <div class="col-md-9">
    <!-- 横並びにするため flexbox を使用 -->
                <div class="d-flex flex-wrap gap-4">
                 @foreach($rooms as $room)
            <div class="card h-100 {{ !$room->available ? 'opacity-50' : '' }}" 
                 style="width: 400px; flex: 0 0 auto;">
        
                            <!-- 画像フィールド（まだ使わないので空） -->
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height:300px;">
                    <span class="text-muted fs-4">画像スペース</span>
                            </div>

                            <div class="card-body">
                    <h3 class="card-title fw-bold">{{ $room->type_name }}</h3>
                    <p class="card-text fs-4">料金: ¥{{ number_format($room->price) }}</p>
                    <p class="card-text fs-5">残り部屋数: {{ $room->remaining_rooms }} / {{ $room->total_rooms }}</p>
          
                    <div class="form-check mt-4">
                                <input class="form-check-input" type="radio" name="room_id" value="{{ $room->id }}"
                                    id="room{{ $room->id }}" {{ !$room->available ? 'disabled' : '' }}
                                    onchange="enableReserveBtn(); updateTotal();">
                        <label class="form-check-label fw-bold fs-5" for="room{{ $room->id }}">
                                  {{ $room->available ? '選択可能' : '満室' }}
                                </label>
                              </div>
                            </div>
                        </div>                   
                    @endforeach
                    </div>
                 </div>

            {{-- JavaScriptを追加 --}}
            <script>
            function enableReserveBtn() {
                const btn = document.getElementById('reserveBtn');
                btn.disabled = false;               // ボタンを有効化
                btn.classList.remove('text-white'); // 白文字を削除
                btn.classList.add('text-black');    // 黒文字を追加
            }
function updateTotal() {
    let total = 0;

    // 選択された部屋の料金を取得
    const selectedRoom = document.querySelector('input[name="room_id"]:checked');
    if (selectedRoom) {
        // 部屋カード内の「料金: ¥xxxx」を確実に取得
        const priceElement = selectedRoom.closest('.card').querySelector('.card-text.fs-4');
        if (priceElement) {
            const price = parseInt(priceElement.innerText.replace(/[^0-9]/g, ''), 10);
            total += price;
        }
    }

    // 人数を反映
    const guestsInput = document.getElementById('guest_count');
    const guests = guestsInput ? parseInt(guestsInput. value, 10) || 1 : 1;

    // プラン料金を反映（例: 朝食 3000円/人）
    const breakfast = document.getElementById('planBreakfast');
    if (breakfast && breakfast.checked) {
        total += 3000 * guests;
    }

    // 合計金額を表示
    document.getElementById('totalPrice').innerText = "合計金額: ¥" + total.toLocaleString();
}



            </script>
           
        </form>
         @endif
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
                                  <button type="submit" onclick="return confirm('本当にキャンセルしますか？')" class="bg-red-500 text-black px-3 py-1 rounded">
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
@endsection
