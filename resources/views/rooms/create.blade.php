@extends('layouts.admin_base')

@section('title', '新規部屋タイプ追加')

@section('page_breadcrumb')
<span class="header-page-title">新規部屋タイプ追加</span>
<a href="{{ route('rooms.index') }}" class="header-back-link">
    <i class="fas fa-arrow-left me-2"></i> 部屋タイプ管理に戻る
</a>
@endsection

@section('content')

<div class="card p-4 mx-auto" style="max-width: 800px;">

    <h2 class="h4 mb-4 text-white-75">新しい部屋タイプの詳細</h2>

    <form method="POST" action="{{ route('rooms.store') }}">
        @csrf

        {{-- 部屋タイプ名 --}}
        <div class="mb-3">
            <label for="type_name" class="form-label">部屋タイプ名</label>
            <input type="text"
                class="form-control"
                id="type_name"
                name="type_name"
                value="{{ old('type_name') }}"
                required
                style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
            @error('type_name')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- 説明 --}}
        <div class="mb-3">
            <label for="description" class="form-label">説明</label>
            <textarea class="form-control"
                id="description"
                name="description"
                rows="3"
                required
                style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">{{ old('description') }}</textarea>
            @error('description')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            {{-- 料金 (price) --}}
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">料金 (円)</label>
                <select class="form-select"
                    id="price"
                    name="price"
                    required
                    style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                    <option value="">選択してください</option>
                    <option value="120000" {{ old('price') == 120000 ? 'selected' : '' }}>120,000円</option>
                    <option value="200000" {{ old('price') == 200000 ? 'selected' : '' }}>200,000円</option>
                </select>
                @error('price')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 定員 (capacity) --}}
            <div class="col-md-6 mb-3">
                <label for="capacity" class="form-label">定員 (名)</label>
                <select class="form-select"
                    id="capacity"
                    name="capacity"
                    required
                    style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                    <option value="">選択してください</option>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ old('capacity') == $i ? 'selected' : '' }}>
                        {{ $i }} 名
                        </option>
                        @endfor
                </select>
                @error('capacity')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            {{-- 部屋数 (total_rooms) --}}
            <div class="col-md-6 mb-3">
                <label for="total_rooms" class="form-label">部屋数</label>
                <select class="form-select"
                    id="total_rooms"
                    name="total_rooms"
                    required
                    style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                    <option value="">選択してください</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('total_rooms') == $i ? 'selected' : '' }}>
                        {{ $i }} 室
                        </option>
                        @endfor
                </select>
                @error('total_rooms')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>


        {{-- 画像URLの複数入力エリア --}}
        <div class="mb-4 card p-3" style="background-color: #383845; border: 1px solid #4a4a58;">
            <h5 class="mb-3 text-white">客室画像登録 (URL入力)</h5>

            <p class="form-label mb-2 text-white-75">画像URLを入力してください（最大3枚推奨）</p>

            @for ($i = 0; $i < 3; $i++) {{-- 💡 $iを0から開始 --}}
                <div class="mb-3 d-flex align-items-center">
                <label class="me-2 text-white-50 flex-shrink-0" style="width: 40px;">#{{ $i + 1 }}</label>
                <input type="url"
                    class="form-control new-image-url-input me-3"
                    name="new_image_urls[]"
                    placeholder="画像URLを入力 (順序 {{ $i + 1 }})"
                    value="{{ old('new_image_urls.' . $i) }}" {{-- 💡 old()のインデックスも $i --}}
                    data-preview-id="new_image_preview_{{ $i }}" {{-- 💡 IDのインデックスも $i --}}
                    style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                <img id="new_image_preview_{{ $i }}"
                    src="{{ old('new_image_urls.' . $i) }}"
                    alt="プレビュー"
                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #4a4a58; display: {{ old('new_image_urls.' . $i) ? 'block' : 'none' }};">
        </div>
        @endfor

        <div class="form-text text-white-50 mt-2">
            空欄のURLは登録されません。
        </div>

        @error('new_image_urls.*')
        <div class="text-danger small mt-1">画像URLの形式が無効です。</div>
        @enderror
</div>

{{-- 登録ボタン --}}
<div class="d-grid gap-2">
    <button type="submit" class="btn btn-primary btn-lg">
        <i class="fas fa-save me-2"></i> 部屋タイプを登録
    </button>
</div>
</form>
</div>

@endsection

{{-- プレビュー用JavaScript --}}
@push('scripts')
<script src="{{ asset('js/image_preview.js') }}"></script>
@endpush