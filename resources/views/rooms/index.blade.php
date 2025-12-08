@extends('layouts.admin_base')

@section('title', '部屋タイプ管理')

{{-- ヘッダー左側の2段構成を定義 --}}
@section('page_breadcrumb')

{{-- 上段: ページタイトル --}}
<span class="header-page-title">部屋タイプ管理</span>

{{-- 下段: 戻るリンク --}}

<a href="#" class="header-back-link">
    <i class="fas fa-arrow-left me-2"></i> 管理者メニューに戻る
</a>
@endsection

{{-- メインコンテンツエリアにコンテンツを挿入 --}}
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fs-5 m-0">部屋タイプ一覧</h2>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> 新規追加
    </a>
</div>

<div class="card p-4 mb-3">
    <p>ここに部屋のタイプを並べる。</p>

</div>

@endsection