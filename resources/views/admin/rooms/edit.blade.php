@extends('layouts.admin_base')


@section('page_breadcrumb')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 w-100">

    <h1 class="h4 fw-bold mb-4">部屋タイプ編集</h1>

</div>
@endsection

@section('content')
<div class="mx-auto" style="max-width: 1000px;">

    {{-- メインフォーム開始: 更新 (rooms.update) --}}
    <form id="updateForm" method="POST" action="{{ route('admin.rooms.update', $room) }}">
        @csrf
        @method('PUT')

        {{-- フォーム入力エリア（カード枠内） --}}
        <div class="card p-4 shadow-sm">
            <h2 class="h4 mb-4 text-white-75 border-bottom border-secondary pb-2">部屋タイプの詳細編集</h2>

            {{-- 部屋タイプ名 --}}
            <div class="mb-3">
                <label for="type_name" class="form-label">部屋タイプ名</label>
                <input type="text" class="form-control" id="type_name" name="type_name"
                    value="{{ old('type_name', $room->type_name) }}" required>
                @error('type_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 説明 --}}
            <div class="mb-3">
                <label for="description" class="form-label">説明</label>
                <textarea class="form-control" id="description" name="description" rows="10" required>{{ old('description', $room->description) }}</textarea>
                @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">

                {{-- プラン (plan) [1番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="plan" class="form-label">基本プラン</label>
                    <select name="plan" id="plan" class="form-select" required>
                        {{-- old('plan')がない場合は $room->plan を使用 --}}
                        <option value="0" @selected(old('plan', $room->plan ?? 0) == 0)>素泊まり</option>
                    </select>
                </div>

                {{-- 料金 (price) [2番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">料金 (円)</label>
                    <select class="form-select" id="price" name="price" required>
                        <option value="">選択してください</option>
                        {{-- old('price')がない場合は $room->price を使用 --}}
                        <option value="120000" @selected(old('price', $room->price ?? null) == 120000)>120,000円</option>
                        <option value="200000" @selected(old('price', $room->price ?? null) == 200000)>200,000円</option>
                    </select>
                    @error('price')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">

                {{-- 定員 (capacity) [3番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="capacity" class="form-label">定員 (名)</label>
                    <select class="form-select" id="capacity" name="capacity" required>
                        <option value="">選択してください</option>
                        @for ($i = 1; $i <= 4; $i++)
                            {{-- old('capacity')がない場合は $room->capacity を使用 --}}
                            <option value="{{ $i }}" @selected(old('capacity', $room->capacity ?? null) == $i)>{{ $i }} 名</option>
                            @endfor
                    </select>
                    @error('capacity')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 部屋数 (total_rooms) [4番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="total_rooms" class="form-label">部屋数 (残り部屋数: {{ $remainingRooms }}室)</label>
                    <select class="form-select" id="total_rooms" name="total_rooms" required>
                        <option value="">選択してください</option>
                        @for ($i = 1; $i <= 5; $i++)
                            {{-- old('total_rooms')がない場合は $room->total_rooms を使用 --}}
                            <option value="{{ $i }}" @selected(old('total_rooms', $room->total_rooms ?? null) == $i)>{{ $i }} 室</option>
                            @endfor
                    </select>
                    @error('total_rooms')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- 画像URL入力セクション --}}
            <div class="mt-4 p-3 rounded" style="background-color: rgba(255,255,255,0.05); border: 1px solid #4a4a58;">
                <h5 class="mb-3 text-white"><i class="fas fa-images me-2"></i>客室画像設定</h5>

                @php $roomImages = $room->images->values(); @endphp

                @for ($i = 0; $i < 5; $i++)
                    @php
                    // 既存の画像URLを取得 (インデックスが存在しない場合はnull)
                    $existingImageUrl=optional($roomImages->get($i))->image_url;
                    // バリデーションエラー時のold値を優先、なければ既存DB値を使用
                    $currentUrl = old('new_image_urls.' . $i, $existingImageUrl);
                    @endphp

                    <div class="mb-3 d-flex align-items-center image-url-group gap-2">
                        <label class="text-white-50 flex-shrink-0" style="width: 30px;">#{{ $i + 1 }}</label>
                        <div class="input-group flex-grow-1">
                            <input type="url" class="form-control new-image-url-input" name="new_image_urls[]"
                                placeholder="画像URLを入力" value="{{ $currentUrl }}" data-preview-id="new_image_preview_{{ $i }}">
                            <button type="button" class="btn btn-outline-secondary btn-clear-url">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        {{-- 画像プレビュー --}}
                        <img id="new_image_preview_{{ $i }}" src="{{ $currentUrl }}" alt="プレビュー"
                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #4a4a58; display: {{ $currentUrl ? 'block' : 'none' }};">
                    </div>
                    @endfor

                    <div class="form-text text-white-50">
                        <i class="fas fa-info-circle me-1"></i> 空欄にすると画像は削除されます。1枚目がメイン画像になります。
                    </div>

                    {{-- エラー表示エリア --}}
                    @error('new_image_urls.*')
                    <div class="text-danger small mt-2">
                        <i class="fas fa-exclamation-triangle me-1"></i> 画像URLの形式が正しくありません。
                        @foreach ($errors->get('new_image_urls.*') as $messages)
                        @foreach ($messages as $message)
                        <br>{{ $message }}
                        @endforeach
                        @endforeach
                    </div>
                    @enderror
            </div>
        </div>
    </form>
    {{-- メインフォーム終了（ボタンは外側に配置） --}}


    {{-- アクションボタンエリア (レスポンシブ配置) --}}
    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4 mb-5">

        {{-- 1. 更新ボタン (メインアクション) --}}
        {{-- ★修正: form属性でメインフォーム(id="updateForm")を指定して送信 --}}
        <button type="submit" form="updateForm"
            class="btn btn-primary btn-sm w-100 btn-update-w shadow-sm">
            <i class="fas fa-check-circle me-2"></i>更新
        </button>

        {{-- 2. 削除フォーム (独立) --}}
        {{-- ★修正: フォームの入れ子を避け、独立したフォームとして定義 --}}
        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
            onsubmit="return confirm('{{ $room->type_name }} を削除してもよろしいですか？\n（この操作は元に戻せません）');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="btn btn-danger btn-sm w-100 btn-delete-w shadow-sm">
                <i class="fas fa-trash-alt me-1"></i>削除
            </button>
        </form>

        {{-- 3. キャンセルボタン --}}
        <a href="{{ route('admin.rooms.index') }}"
            class="btn btn-secondary btn-sm w-100 btn-cancel-w shadow-sm">
            <i class="fas fa-undo me-2"></i>キャンセル
        </a>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/rooms_image_preview.js') }}"></script>
@endpush