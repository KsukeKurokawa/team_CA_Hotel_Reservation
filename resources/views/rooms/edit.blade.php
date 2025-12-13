@extends('layouts.admin_base')

@section('title', '部屋タイプ編集')

@section('page_breadcrumb')
<span class="header-page-title">部屋タイプ編集</span>
<a href="{{ route('rooms.index') }}" class="header-back-link">
    <i class="fas fa-arrow-left me-2"></i> 部屋タイプ一覧に戻る
</a>
@endsection

@section('content')
<div class="mx-auto" style="max-width: 1000px;">
    {{-- メインのフォーム開始 --}}
    <form method="POST" action="{{ route('rooms.update', $room->id) }}">
        @csrf
        @method('PUT')

        {{-- 入力エリア（カード枠内） --}}
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
                <textarea class="form-control" id="description" name="description" rows="6" required>{{ old('description', $room->description) }}</textarea>
                @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">

                {{-- 料金 (price) --}}
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">料金 (円)</label>
                    <select class="form-select" id="price" name="price" required>
                        <option value="">選択してください</option>
                        @php $selectedPrice = old('price', $room->price); @endphp
                        <option value="120000" @selected($selectedPrice==120000)>120,000円</option>
                        <option value="200000" @selected($selectedPrice==200000)>200,000円</option>
                    </select>
                    @error('price')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 定員 (capacity) --}}
                <div class="col-md-6 mb-3">
                    <label for="capacity" class="form-label">定員 (名)</label>
                    <select class="form-select" id="capacity" name="capacity" required>
                        <option value="">選択してください</option>
                        @php $selectedCapacity = old('capacity', $room->capacity); @endphp
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}" @selected($selectedCapacity==$i)>{{ $i }} 名</option>
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
                    <select class="form-select" id="total_rooms" name="total_rooms" required>
                        <option value="">選択してください</option>
                        @php $selectedTotalRooms = old('total_rooms', $room->total_rooms); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @selected($selectedTotalRooms==$i)>{{ $i }} 室</option>
                            @endfor
                    </select>
                    @error('total_rooms')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- プラン (plan) --}}
                <div class="col-md-6 mb-3">
                    <label for="plan" class="form-label">プラン</label>
                    <select name="plan" id="plan" class="form-select" required>
                        <option value="0" @selected(old('plan', $room->plan) == 0)>素泊まり</option>
                    </select>
                </div>
            </div>

            {{-- 画像URL入力セクション（内側のデザイン用カード） --}}
            <div class="mt-4 p-3 rounded" style="background-color: rgba(255,255,255,0.05); border: 1px solid #4a4a58;">
                <h5 class="mb-3 text-white"><i class="fas fa-images me-2"></i>客室画像設定</h5>

                @php $roomImages = $room->images->values(); @endphp

                @for ($i = 0; $i < 5; $i++)
                    @php
                    $existingImageUrl=optional($roomImages->get($i))->image_url;
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
                        <img id="new_image_preview_{{ $i }}" src="{{ $currentUrl }}" alt="プレビュー"
                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #4a4a58; display: {{ $currentUrl ? 'block' : 'none' }};">
                    </div>
                    @endfor

                    <div class="form-text text-white-50">
                        <i class="fas fa-info-circle me-1"></i> 空欄にすると画像は削除されます。1枚目がメイン画像になります。
                    </div>
                    @error('new_image_urls.*')
                    <div class="text-danger small mt-2">画像URLの形式が正しくありません。</div>
                    @enderror
            </div>
        </div>
        {{-- メインカード終了 --}}

        {{-- ボタンエリア（カードの外側に配置） --}}
        <div class="d-flex justify-content-center gap-3 mt-4 mb-5">
            <button type="submit" class="btn btn-primary btn-lg shadow" style="width: 250px;">
                <i class="fas fa-check-circle me-2"></i>更新を保存する
            </button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-lg" style="width: 150px;">
                キャンセル
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/image_preview.js') }}"></script>
@endpush