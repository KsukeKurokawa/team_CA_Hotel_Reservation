@extends('layouts.booking')

@section('content')
    <div class="max-w-screen-2xl mx-auto p-6" style="background-color: #f5f5dc;">

        <!-- タブナビゲーション -->
        <ul class="nav nav-tabs mb-3" id="bookingTabs" role="tablist">
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
        <div class="tab-content" id="bookingTabsContent">

            <!-- 予約フォーム -->
            <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
                <form action="{{ route('booking.store') }}" method="POST" class="mt-6">
                    @csrf

                    <div class="row">
                        {{-- 左サイドバー --}}
                        <div class="col-md-4">
                            <div class="bg-white p-4 rounded shadow">

                                {{-- チェックイン日選択 --}}
                                <div class="mb-3">
                                    <label for="check_in_date">
                                        <i class="fas fa-calendar-alt me-2 text-secondary"></i>チェックイン
                                    </label>

                                    <input type="date" id="check_in_date"
                                        value="{{ request('check_in_date') ?? now()->format('Y-m-d') }}"
                                        min="{{ now()->format('Y-m-d') }}"
                                        onchange="window.location='{{ route('booking.create') }}?check_in_date=' + encodeURIComponent(this.value)"
                                        class="form-control">
                                </div>

                                {{-- チェックアウト日(翌日固定) --}}
                                <div class="mb-3">
                                    <label for="check_out_date" class="form-label fw-bold">
                                        <i class="fas fa-calendar-check me-2 text-secondary"></i> チェックアウト</label>
                                    <input type="date" id="check_out_date"
                                        value="{{ request('check_in_date') ? \Carbon\Carbon::parse(request('check_in_date'))->addDay()->format('Y-m-d') : now()->addDay()->format('Y-m-d') }}"
                                        class="form-control" readonly>
                                </div>

                                {{-- hiddenで選択日を保持（予約確定時に送信される） --}}
                                <input type="hidden" name="check_in_date"
                                    value="{{ request('check_in_date') ?? now()->format('Y-m-d') }}">

                                {{-- 人数入力 --}}
                                <label class="mt-4">
                                    <i class="fas fa-user-friends me-2 text-secondary"></i> 人数
                                    <input type="number" name="guest_count" value="2" max="4" min="1"
                                        class="form-control">
                                </label>


                                {{-- 合計金額 --}}
                                <div class="mt-3 mb-3 p-4 bg-opacity-25 border border-danger rounded text-center shadow">
                                    <span class="fw-bold fs-4 text-dark me-2">合計金額:</span>
                                    <span id="totalPrice" class="fs-2 fw-bold text-danger">¥0</span>
                                </div>

                                {{-- 予約確定ボタン(初期は白文字+disabled) --}}
                                <button type="submit" class="mt-6 bg-amber-600 text-white px-4 py-2 rounded"
                                    id="reserveBtn" disabled>
                                    予約確定
                                </button>
                            </div>
                        </div>

                        {{-- 右メインエリア --}}
                        <div class="col-md-8">
                            <div class="row">
                                @foreach ($rooms as $room)
                                    {{-- 部屋カード(Bootstrapのカードを使用) --}}
                                    <div class="col-md-6 mb-4">
                                        <div class="card flex-fill shadow-sm {{ !$room->available ? 'opacity-50' : '' }}"
                                            style="min-height: 800px; background-color: #fff8dc">

                                            {{-- カードヘッダー：部屋タイプ --}}
                                            <div class="card-header bg-dark text-white">
                                                <h2 class="h-5 mb-0">{{ $room->type_name }}</h2>
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-between"
                                                style="height: 100%;">
                                                <img src="https://picsum.photos/400/250?random={{ $room->id }}"
                                                    alt="{{ $room->type_name }}" class="img-fluid mb-3 rounded"
                                                    style="height: 480px; object-fit: cover; width: 100%;">


                                                {{-- 部屋画像（URLから表示）一旦非常時------ 
                        @if ($room->image_url)
                            <img src="{{ $room->image_url }}" 
                                 alt="{{ $room->type_name }}" 
                                 class="img-fluid mb-3 rounded"
                                 style="height: 480px; object-fit: cover; width: 100%;">
                        @endif 
                        ------------------------------------ --}}


                                                {{-- 料金の表示 --}}
                                                <p class="fs-3 fw-bold mt-3">料金: ¥{{ number_format($room->price) }}</p>

                                                <p class="fs-4">残り部屋数: {{ $room->remaining_rooms }} /
                                                    {{ $room->total_rooms }}</p>

                                                {{-- 部屋選択ラジオボタン --}}
                                                <div class="form-check d-flex align-items-center mt-3">
                                                    <input class="form-check-input" type="radio" name="room_id"
                                                        value="{{ $room->id }}"
                                                        {{ !$room->available ? 'disabled' : '' }}
                                                        data-price="{{ $room->price }}" onchange="enableReserveBtn()"
                                                        style="transform: scale(1.8); margin-right:0.6rem;">
                                                    <label class="form-check-label fs-2 fw-bold mb-0">
                                                        {{ $room->available ? '空室有り' : '満室' }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 予約一覧 -->
            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                <div class="container">

                    <div class="card shadow-lg border-0 mb-5">
                        <div class="card-header bg-gradient text-black"
                            style="background: linear-gradient(to right, #3c2f2f, #5a4635);">
                            <h3 class="mb-0"><i class="fas fa-list me-2"></i> ご予約一覧</h3>
                        </div>
                        <div class="card-body p-4">

                            @if ($reservations->isEmpty())
                                <p>現在、予約はありません。</p>
                            @else
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th><i class="fas fa-id-badge me-1 text-secondary"></i> 予約ID</th>
                                            <th><i class="fas fa-bed me-1 text-secondary"></i> 部屋タイプ</th>
                                            <th><i class="fas fa-calendar-alt me-1 text-secondary"></i> チェックイン</th>
                                            <th><i class="fas fa-user-friends me-1 text-secondary"></i> 人数</th>
                                            <th><i class="fas fa-yen-sign me-1 text-secondary"></i> 金額</th>
                                            <th><i class="fas fa-info-circle me-1 text-secondary"></i> ステータス</th>
                                            <th><i class="fas fa-cogs me-1 text-secondary"></i> 操作</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reservations as $reservation)
                                            <tr>
                                                <td>booking-{{ $reservation->id }}</td>
                                                <td>{{ $reservation->room->type_name }}</td>
                                                <td>{{ $reservation->check_in->format('Y-m-d') }}</td>
                                                <td>{{ $reservation->guests }}名</td>
                                                <td>¥{{ number_format($reservation->total_price) }}</td>
                                                <td>
                                                    @if ($reservation->status === 'confirmed')
                                                        <span class="badge bg-success">確定</span>
                                                    @else
                                                        <span class="badge bg-secondary">キャンセル済み</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($reservation->status === 'confirmed')
                                                        <form action="{{ route('booking.cancel', $reservation->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirm('本当にキャンセルしますか？')"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fas fa-times-circle me-1"></i>キャンセル
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

            </div>
        </div>

    </div>
</div>
@endsection
                <!-- 予約完了モーダル -->
                @if (session('booking'))
                    <div class="modal fade show" id="bookingCompleteModal" tabindex="-1"
                        aria-labelledby="bookingCompleteLabel" aria-hidden="true" style="display:block;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-green-600 text-white">
                                    <h5 class="modal-title" id="bookingCompleteLabel">予約が完了しました！</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="閉じる"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>ご予約ありがとうございます。予約が完了いたしました。ご来館を心よりお待ちしております。</strong></p>
                                    <p><strong>予約ID:</strong> booking-{{ session('booking.id') }}</p>
                                    <p><strong>部屋タイプ:</strong> {{ session('booking.room_name') }}</p>
                                    <p><strong>チェックイン:</strong> {{ session('booking.check_in') }}</p>
                                    <p><strong>チェックアウト:</strong> {{ session('booking.check_out_date') }}</p>
                                    <p><strong>人数:</strong> {{ session('booking.guests') }}名</p>
                                    <p><strong>料金:</strong> ¥{{ number_format(session('booking.total_price')) }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- モーダルの自動表示用スクリプト -->
                @if (session('booking'))
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var bookingModal = document.getElementById('bookingCompleteModal');
                            var modal = new bootstrap.Modal(bookingModal);
                            modal.show();
                        });
                    </script>
                @endif

                {{-- JavaScriptで予約ボタンを有効化＋文字色変更 --}}
                <script>
                    function enableReserveBtn() {
                        const btn = document.getElementById('reserveBtn');
                        btn.disabled = false; // ボタンを有効化
                        btn.classList.remove('text-white'); // 白文字を削除
                        btn.classList.add('text-black'); // 黒文字を追加
                    }
                </script>

                {{-- JavaScriptで合計金額を反映させる --}}
                <script>
                document.addEventListener("DOMContentLoaded", function(){
                    function updateTotalPrice() {
                        let basePrice = 0;

                        // 選択された部屋の料金を取得
                        const selectedRoom = document.querySelector('[name="room_id"]:checked');
                        if (selectedRoom) {
                            basePrice = parseInt(selectedRoom.dataset.price);
                        }

                        // 合計金額を反映
                        document.getElementById('totalPrice').textContent = '¥' + basePrice.toLocaleString();
                    }

                    // イベントリスナー
                    document.querySelectorAll('[name="room_id"], [name="guest_count"]').forEach(el => {
                        el.addEventListener('change', updateTotalPrice);
                    });
                });
                </script>