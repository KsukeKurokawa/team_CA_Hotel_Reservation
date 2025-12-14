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
            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">
                部屋タイプ詳細情報
            </li>
        </ol>
    </nav>

</div>
@endsection

@section('content')
{{-- カード本体 (最大幅 1000px) --}}
<div class="card p-4 mx-auto shadow" style="max-width: 1000px;">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-50">
        <h2 class="h4 text-white fw-bold">{{ $room->type_name }}</h2>
    </div>

    {{-- 1. 画像ギャラリーエリア --}}
    @php
    $images = $room->images->values(); // キーをゼロベースにリセット
    $hasImages = $images->isNotEmpty();
    @endphp

    <div class="mb-4">
        @if ($hasImages)
        {{-- メイン画像 (1枚目) --}}
        <div class="mb-3 overflow-hidden rounded shadow-sm" style="height: 450px; background-color: var(--admin-header-bg);">
            <img id="main-image"
                src="{{ $images->first()->image_url ?? '' }}"
                alt="メイン画像"
                style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">
        </div>

        {{-- サムネイルギャラリー (クリックでメイン画像切り替え) --}}
        <div class="d-flex gap-2 overflow-x-auto pb-1">
            @foreach ($images->take(5) as $image)
            <img class="thumbnail-image rounded border"
                src="{{ $image->image_url }}"
                alt="サムネイル {{ $loop->iteration }}"
                data-full-url="{{ $image->image_url }}"
                style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border-color: transparent; opacity: 0.8; transition: all 0.2s;">
            @endforeach
        </div>
        @else
        {{-- 画像なし時の表示 --}}
        <div class="d-flex flex-column align-items-center justify-content-center mb-3 rounded border border-secondary p-5" style="height: 300px; background-color: var(--admin-header-bg);">
            <i class="fas fa-image fa-5x text-white-50 mb-3"></i>
            <p class="text-white-50">登録画像なし</p>
        </div>
        @endif
    </div>

    {{-- 2. 詳細情報エリア --}}
    <div class="row mb-4">
        {{-- 左側: 料金と基本情報 --}}
        <div class="col-md-6 mb-4 mb-md-0">
            <h5 class="text-white-75 mb-3"><i class="fas fa-tag me-2 text-primary"></i> 料金と基本情報</h5>
            <table class="table table-dark table-striped border-top border-secondary border-opacity-50">
                <tbody>
                    <tr>
                        <th class="border-secondary border-opacity-50" style="width: 40%;">料金 (1泊)</th>
                        <td class="fw-bold text-primary fs-5 border-secondary border-opacity-50">¥{{ number_format($room->price) }}</td>
                    </tr>
                    <tr>
                        <th class="border-secondary border-opacity-50">定員</th>
                        <td class="border-secondary border-opacity-50"><i class="fas fa-user-friends me-1"></i> {{ $room->capacity }} 名</td>
                    </tr>
                    <tr>
                        <th class="border-secondary border-opacity-50">総部屋数</th>
                        <td class="border-secondary border-opacity-50">{{ $room->total_rooms }} 室</td>
                    </tr>
                    <tr>
                        <th class="border-secondary border-opacity-50">作成日</th>
                        <td class="border-secondary border-opacity-50">{{ $room->created_at->format('Y/m/d H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="border-secondary border-opacity-50">最終更新日</th>
                        <td class="border-secondary border-opacity-50">{{ $room->updated_at->format('Y/m/d H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- 右側: 説明文 --}}
        <div class="col-md-6">
            <h5 class="text-white-75 mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> 部屋タイプの説明</h5>
            <div class="p-3 rounded border border-secondary-subtle" style="background-color: var(--admin-header-bg);">
                <p class="text-white mb-0" style="white-space: pre-wrap;">{{ $room->description }}</p>
            </div>
        </div>
    </div>
</div>

{{-- アクションボタンエリア (レスポンシブ配置) --}}
{{-- モバイル(縦並び・全幅) -> PC(横並び・カスタム幅) --}}
<div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4 mb-5">

    {{-- 1. 戻るボタン (一覧に戻る) --}}
    <a href="{{ route('rooms.index') }}"
        class="btn btn-secondary btn-sm w-100 w-sm-auto btn-show-back-w shadow-sm">
        <i class="fas fa-undo me-2"></i> 一覧に戻る
    </a>

    {{-- 2. 編集ボタン (メインアクション) --}}
    <a href="{{ route('rooms.edit', $room->id) }}"
        class="btn btn-warning btn-sm w-100 w-sm-auto btn-show-edit-w text-white shadow-sm">
        <i class="fas fa-pencil-alt me-2"></i> 編集する
    </a>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/rooms_show_gallery.js') }}"></script>
@endpush