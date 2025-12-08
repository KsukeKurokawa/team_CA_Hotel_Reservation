@extends('layouts.admin_base')

@section('title', '部屋タイプ編集')

{{-- 1. ヘッダー左側の2段構成を定義 --}}
@section('page_breadcrumb')

{{-- 上段: 戻るリンク --}}
<a href="{{ route('rooms.index') }}" class="header-back-link">
    <i class="fas fa-arrow-left me-2"></i> 部屋タイプ管理に戻る
</a>

{{-- 下段: ページタイトル --}}
<span class="header-page-title">部屋タイプ編集</span>

@endsection

@section('content')

<div class="card p-4 mx-auto" style="max-width: 800px;">

    <h2 class="h4 mb-4 text-white-75">部屋タイプ編集</h2> {{-- タイトル変更 --}}

    {{-- 💡 フォームの修正点 --}}
    <form method="POST" action="{{ route('rooms.update', $room->id) }}">
        @csrf
        @method('PUT') {{-- PUTメソッドで更新を指示 --}}

        {{-- 部屋タイプ名 --}}
        <div class="mb-3">
            <label for="type_name" class="form-label">部屋タイプ名</label>
            <input type="text"
                class="form-control"
                id="type_name"
                name="type_name"
                {{-- 💡 既存データまたはold()を表示 --}}
                value="{{ old('type_name', $room->type_name) }}"
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
                style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">{{ old('description', $room->description) }}</textarea>
            @error('description')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            {{-- 料金 (price) --}}
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">料金 (円)</label>
                <select class="form-select" id="price" name="price" required style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                    <option value="">選択してください</option>
                    {{-- 💡 既存の値が選択されるように調整 --}}
                    @php $selectedPrice = old('price', $room->price); @endphp
                    <option value="120000" {{ $selectedPrice == 120000 ? 'selected' : '' }}>120,000円</option>
                    <option value="200000" {{ $selectedPrice == 200000 ? 'selected' : '' }}>200,000円</option>
                </select>
                @error('price')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- 定員 (capacity) --}}
            <div class="col-md-6 mb-3">
                <label for="capacity" class="form-label">定員 (名)</label>
                <select class="form-select" id="capacity" name="capacity" required style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                    <option value="">選択してください</option>
                    {{-- 💡 既存の値が選択されるように調整 --}}
                    @php $selectedCapacity = old('capacity', $room->capacity); @endphp
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ $selectedCapacity == $i ? 'selected' : '' }}>
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
                <select class="form-select" id="total_rooms" name="total_rooms" required style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">
                    <option value="">選択してください</option>
                    {{-- 💡 既存の値が選択されるように調整 --}}
                    @php $selectedTotalRooms = old('total_rooms', $room->total_rooms); @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ $selectedTotalRooms == $i ? 'selected' : '' }}>
                        {{ $i }} 室
                        </option>
                        @endfor
                </select>
                @error('total_rooms')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="mb-4">
            <label for="image_url" class="form-label">画像URL (1枚目)</label>
            <input type="url"
                class="form-control"
                id="image_url"
                name="image_url"
                {{-- 既存の画像URLを初期値として設定 --}}
                value="{{ old('image_url', $room->primary_image_url) }}"
                style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">

            <div class="mt-3">
                <p class="form-label mb-2">プレビュー:</p>
                <img id="image_preview"
                    {{-- 💡 初期値として既存のURLを設定 --}}
                    src="{{ old('image_url', $room->primary_image_url) }}"
                    alt="プレビュー画像"
                    style="width: 100%; height: auto; max-height: 250px; object-fit: cover; border-radius: 4px; border: 1px solid #4a4a58; display: {{ old('image_url', $room->primary_image_url) ? 'block' : 'none' }};">
                <div id="no_image_text" class="text-white-50" style="display: {{ old('image_url', $room->primary_image_url) ? 'none' : 'block' }};">
                    URLを入力するとここに画像が表示されます。
                </div>
            </div>

            <div class="form-text text-white-50">
                部屋の魅力が伝わる画像のURLを入力してください。（空欄にすると画像は削除されます）
            </div>

            @error('image_url')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        @error('imageUrl')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror

        {{-- 💡 修正箇所: ボタンを横並びで中央に配置 --}}
        <div class="d-flex justify-content-center mt-4">

            {{-- 更新ボタン --}}
            <button type="submit" class="btn btn-primary btn-lg me-3" style="width: 200px;"> {{-- me-3で右にマージン --}}
                更新
            </button>

            {{-- キャンセルボタン --}}
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-lg" style="width: 200px;">
                キャンセル
            </a>

        </div>
    </form>
</div>

@endsection

{{-- 💡 新規登録画面と同じプレビュー用JavaScriptを追記 --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUrlInput = document.getElementById('image_url');
        const imagePreview = document.getElementById('image_preview');
        const noImageText = document.getElementById('no_image_text');

        function updatePreview() {
            const url = imageUrlInput.value;

            if (url && url.startsWith('http')) {
                // 画像をロードしようと試みる
                imagePreview.src = url;
                imagePreview.onload = function() {
                    imagePreview.style.display = 'block';
                    noImageText.style.display = 'none';
                    noImageText.textContent = 'プレビュー画像'; // 成功時はテキストを元に戻す
                };
                imagePreview.onerror = function() {
                    // 画像のロードに失敗した場合
                    imagePreview.style.display = 'none';
                    noImageText.style.display = 'block';
                    noImageText.textContent = '画像URLが無効です。';
                };
            } else {
                // URLが空または無効な場合
                imagePreview.style.display = 'none';
                imagePreview.src = '';
                noImageText.style.display = 'block';
                noImageText.textContent = 'URLを入力するとここに画像が表示されます。';
            }
        }

        imageUrlInput.addEventListener('input', updatePreview);

        // ページロード時の初期チェック
        updatePreview();
    });
</script>
@endpush