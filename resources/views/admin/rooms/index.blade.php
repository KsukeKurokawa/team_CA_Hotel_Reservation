@extends('layouts.admin_base')


@section('page_breadcrumb')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 w-100">
 
        <h1 class="h4 fw-bold mb-4">部屋タイプ一覧</h1>

        {{-- 新規登録ボタン (PCで右寄せ) --}}
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary col-12 col-md-auto shadow-sm">
            <i class="fas fa-plus me-1"></i> 部屋タイプ登録
        </a>

    </div>
    @endsection

    @section('content')

    {{-- 登録成功メッセージ --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- グリッドレイアウト --}}
    <div class="row g-4">
        @forelse ($rooms as $room)

        <div class="col-md-6">
            <div class="card shadow-lg h-100 overflow-hidden border-0">

                {{-- メイン画像コンテナ (高さ固定250px) --}}
                <div class="position-relative" style="height: 250px;">
                    {{-- アクセサ $room->primary_image_url を直接使用 --}}
                    @if ($room->primary_image_url)
                    <img src="{{ $room->primary_image_url }}" alt="{{ $room->type_name }}" class="w-100 h-100" style="object-fit: cover;">
                    @else
                    <div class="d-flex align-items-center justify-content-center h-100 bg-dark bg-opacity-25">
                        <i class="fas fa-image fa-4x text-white-50"></i>
                    </div>
                    @endif
                </div>

                {{-- カードボディコンテンツ --}}
                <div class="p-3">
                    @php
                    $planName = '';
                    $planBadgeClass = 'bg-secondary';
                    if ($room->plan == 0) {
                    $planName = '素泊まりプラン';
                    $planBadgeClass = 'btn-info'; // admin_baseで定義
                    }
                    @endphp

                    <h3 class="fs-5 fw-bold mb-1 text-white d-flex justify-content-between align-items-center">
                        <span>
                            {{ $room->type_name }}
                            <small class="text-light ms-1">［ 全{{ $room->total_rooms }}室 ］</small>
                        </span>
                        {{-- プランバッジ --}}
                        @if ($planName)
                        <span class="badge {{ $planBadgeClass }} text-uppercase ms-2 text-dark">
                            {{ $planName }}
                        </span>
                        @endif
                    </h3>

                    {{-- 補助情報 (定員と料金) --}}
                    <div class="d-flex justify-content-between align-items-center mb-2 pt-1 border-bottom border-secondary border-opacity-50 pb-2">
                        <span class="text-white-50">
                            <i class="fas fa-user-friends me-1"></i> 定員{{ $room->capacity }}名
                        </span>
                        <span class="text-primary fw-bold fs-5">
                            ¥{{ number_format($room->price) }}<span class="fs-6 text-white-50">/泊</span>
                        </span>
                    </div>

                    {{-- サムネイルエリア (48pxサイズ) --}}
                    <div class="d-flex gap-2 mb-3">
                        @php
                        $thumbnails = $room->images->skip(1)->take(4);
                        $maxThumbnails = 4;
                        @endphp

                        @foreach ($thumbnails as $image)
                        <img src="{{ $image->image_url }}" alt="サムネイル"
                            style="width: 48px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid rgba(255,255,255,0.1);">
                        @endforeach

                        {{-- 画像なしのプレースホルダー --}}
                        @for ($i = $thumbnails->count(); $i < $maxThumbnails; $i++)
                            <div class="rounded border border-secondary border-dashed border-opacity-25 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: rgba(255,255,255,0.03);">
                            <i class="fas fa-plus text-white-50" style="font-size: 10px;"></i>
                    </div>
                    @endfor
                </div>

                {{-- 説明文 (高さ制限あり) --}}
                <p class="text-white-75 small mb-3" style="line-height: 1.4; height: 64px; overflow: hidden;">
                    {{ $room->description }}
                </p>
            </div>

            {{-- アクションボタンエリア (レスポンシブ配置) --}}
            {{-- モバイル(縦並び・全幅) -> PC(横並び・カスタム幅) --}}
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 p-3 pt-0">

                {{-- 1. 詳細を見るボタン --}}
                <a href="{{ route('admin.rooms.show', $room) }}"
                    class="btn btn-primary btn-sm w-100 w-sm-auto btn-detail-w shadow-sm">
                    <i class="fas fa-eye me-1"></i> 詳細を見る
                </a>

                {{-- 2. 編集するボタン --}}
                <a href="{{ route('admin.rooms.edit', $room) }}"
                    class="btn btn-warning btn-sm w-100 w-sm-auto btn-edit-w text-white shadow-sm">
                    <i class="fas fa-pencil-alt me-2"></i> 編集する
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-secondary text-center border-0 py-5" style="background-color: rgba(255,255,255,0.05);">
            <i class="fas fa-exclamation-circle fa-2x mb-3 text-white-50 d-block"></i>
            まだ部屋タイプが登録されていません。
        </div>
    </div>
    @endforelse
</div>
@endsection