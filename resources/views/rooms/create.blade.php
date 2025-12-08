@extends('layouts.admin_base') {{-- 共通の親レイアウトを継承 --}}

@section('title', '新規部屋タイプ追加')

{{-- 1. ヘッダー左側の2段構成を定義 --}}
@section('page_breadcrumb')

{{-- 上段: ページタイトル--}}
<span class="header-page-title">新規部屋タイプ追加</span>

{{-- 下段: 戻るリンク --}}
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

            <!-- {{-- planを将来追加予定 (plan) --}} -->

        </div>

        <!-- {{-- 画像URL (imageUrl)あとで追加 --}}
        <div class="mb-4">
            <label for="imageUrl" class="form-label">画像URL</label>
            <input type="url"
                class="form-control"
                id="imageUrl"
                name="imageUrl"
                value="{{ old('imageUrl') }}"
                style="background-color: #383845; color: var(--admin-text-light); border: 1px solid #4a4a58;">

            <div class="form-text text-white-50">
                部屋の魅力が伝わる画像のURLを入力してください。
            </div>

            @error('imageUrl')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div> -->

        {{-- 登録ボタン --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i> 部屋タイプを登録
            </button>
        </div>
    </form>
</div>

@endsection