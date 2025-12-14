@extends('layouts.admin_base')

{{-- ページ固有のパンくずリストを定義 --}}
@section('page_breadcrumb')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 w-100">

    {{-- パンくずリスト --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="#" class="text-white-50 text-decoration-none">
                    <i class="fas fa-home me-1"></i> 管理画面
                </a>
            </li>
            {{-- ★注意: ここは登録/編集で動的に変更されますが、ここでは「登録」のまま残します --}}
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                部屋タイプ登録
            </li>
        </ol>
    </nav>

</div>
@endsection

@section('content')
<div class="mx-auto" style="max-width: 1000px;">
    {{-- フォーム開始: 登録 (rooms.store) または 更新 (rooms.update) --}}
    <form method="POST" action="{{ route('rooms.store') }}">
        @csrf

        {{-- フォーム入力エリア（カード枠内） --}}
        <div class="card p-4 shadow-sm">
            <h2 class="h4 mb-4 text-white-75 border-bottom border-secondary pb-2">部屋タイプの詳細</h2>

            {{-- 部屋タイプ名 --}}
            <div class="mb-3">
                <label for="type_name" class="form-label">部屋タイプ名</label>
                <input type="text" class="form-control" id="type_name" name="type_name"
                    value="{{ old('type_name') }}" required>
                @error('type_name')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 説明 --}}
            <div class="mb-3">
                <label for="description" class="form-label">説明</label>
                <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">

                {{-- プラン (plan) [1番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="plan" class="form-label">プラン</label>
                    <select name="plan" id="plan" class="form-select" required>
                        <option value="0" selected>素泊まり</option>
                    </select>
                </div>

                {{-- 料金 (price) [2番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">料金 (円)</label>
                    <select class="form-select" id="price" name="price" required>
                        <option value="">選択してください</option>
                        <option value="120000" @selected(old('price')==120000)>120,000円</option>
                        <option value="200000" @selected(old('price')==200000)>200,000円</option>
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
                            <option value="{{ $i }}" @selected(old('capacity')==$i)>{{ $i }} 名</option>
                            @endfor
                    </select>
                    @error('capacity')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 部屋数 (total_rooms) [4番目] --}}
                <div class="col-md-6 mb-3">
                    <label for="total_rooms" class="form-label">部屋数</label>
                    <select class="form-select" id="total_rooms" name="total_rooms" required>
                        <option value="">選択してください</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected(old('total_rooms')==$i)>{{ $i }} 室</option>
                            @endfor
                    </select>
                    @error('total_rooms')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- 画像URL入力セクション --}}
            <div class="mt-4 p-3 rounded" style="background-color: rgba(255,255,255,0.05); border: 1px solid #4a4a58;">
                <h5 class="mb-3 text-white"><i class="fas fa-images me-2"></i>客室画像登録</h5>
                <p class="form-label mb-2 text-white-75 small">画像URLを入力してください（最大5枚まで）</p>

                @for ($i = 0; $i < 5; $i++)
                    <div class="mb-3 d-flex align-items-center image-url-group gap-2">
                    <label class="text-white-50 flex-shrink-0" style="width: 30px;">#{{ $i + 1 }}</label>
                    <div class="input-group flex-grow-1">
                        <input type="url" class="form-control new-image-url-input" name="new_image_urls[]"
                            placeholder="画像URLを入力" value="{{ old('new_image_urls.' . $i) }}" data-preview-id="new_image_preview_{{ $i }}">
                        <button type="button" class="btn btn-outline-secondary btn-clear-url">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    {{-- 画像プレビュー --}}
                    <img id="new_image_preview_{{ $i }}" src="{{ old('new_image_urls.' . $i) }}" alt="プレビュー"
                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #4a4a58; display: {{ old('new_image_urls.' . $i) ? 'block' : 'none' }};">
            </div>
            @endfor

            <div class="form-text text-white-50">
                <i class="fas fa-info-circle me-1"></i> 画像は上から順に表示されます。1枚目がメイン画像になります。
            </div>
            @error('new_image_urls.*')
            <div class="text-danger small mt-2">画像URLの形式が正しくありません。</div>
            @enderror
        </div>
</div>
{{-- フォーム入力エリア終了 --}}

{{-- アクションボタンエリア (レスポンシブ配置) --}}
{{-- モバイル(縦並び・全幅) -> PC(横並び・カスタム幅) --}}
<div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4 mb-5">

    {{-- 1. 更新/登録ボタン --}}
    {{-- ※ 登録画面では form="updateForm" は不要ですが、編集画面との共通化のためこの形を維持します --}}
    <button type="submit" form="updateForm"
        class="btn btn-primary btn-sm w-100 w-sm-auto btn-update-w shadow-sm">
        <i class="fas fa-check-circle me-2"></i>登録
    </button>

    {{-- 2. キャンセルボタン --}}
    <a href="{{ route('rooms.index') }}"
        class="btn btn-secondary btn-sm w-100 w-sm-auto btn-cancel-w shadow-sm">
        <i class="fas fa-undo me-2"></i> キャンセル
    </a>

</div>
</form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/rooms_image_preview.js') }}"></script>
@endpush