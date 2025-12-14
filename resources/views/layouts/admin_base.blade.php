<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '管理画面') | 予約管理システム</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

    <style>
        /* ==================================================== */
        /* 1. 変数定義 & 基本設定 (Bootstrap上書き) */
        /* ==================================================== */
        :root {
            /* ダークテーマ系 */
            --admin-bg-dark: #12121c;
            --admin-header-bg: #1e1e2d;
            --admin-text-light: #e0e0e0;
            --admin-text-secondary: #a0a0a0;

            /* カラーパレット (Bootstrap変数) */
            --bs-primary: #4080c9ff;
            --bs-primary-rgb: 74, 144, 226;
            --admin-accent: var(--bs-primary);

            --bs-warning: #c5820fff;
            --bs-warning-rgb: 245, 166, 35;

            --bs-danger: #b8091eff;
            --bs-danger-rgb: 208, 2, 27;

            --bs-info: #49cfb2ff;
            --bs-info-rgb: 80, 227, 194;
        }

        body {
            background-color: var(--admin-bg-dark);
            color: var(--admin-text-light);
            min-height: 100vh;
            font-size: 1.1rem;
            font-family: 'Noto Sans JP', sans-serif !important;
        }

        /* ==================================================== */
        /* 1-A. ボタン共通設定 (全ボタンに適用) */
        /* ==================================================== */

        /* ボタン共通: ホバー時の発光エフェクト */
        .btn:hover {
            filter: brightness(1.15) !important;
            color: #ffffff !important;
            transform: none !important;
        }

        /* ==================================================== */
        /* 2. ヘッダー / ナビゲーション (最重要部分) */
        /* ==================================================== */

        /* --- ヘッダー領域 --- */
        .admin-header {
            background-color: var(--admin-header-bg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
            padding: 0.6rem 1rem;
        }

        /* --- ログアウトボタン (統合済み) --- */
        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.5) !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .btn-outline-light:hover {
            color: var(--admin-header-bg) !important;
        }

        /* --- ページ固有ヘッダー (パンくずエリア) --- */
        .page-header-area {
            padding-top: 20px !important;
            padding-bottom: 10px !important;
        }

        /* --- メニュー項目のベーススタイル (PC/SP共通の見た目) --- */
        .main-global-nav .nav-tab-item,
        .custom-mobile-dropdown-menu .dropdown-item {
            text-decoration: none;
            color: var(--admin-text-light) !important;
            background-color: transparent;
            opacity: 0.8;
            transition: all 0.2s;
            font-size: 0.95rem;
            border: 1px solid transparent;
            display: block;
            border-radius: 0.3rem;
        }

        .main-global-nav .nav-tab-item {
            display: inline-block;
        }

        /* --- [Hover] 非アクティブ時のホバー --- */
        .main-global-nav .nav-tab-item:hover,
        .dropdown-item:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.1);
            opacity: 1;
        }

        /* --- [Active] アクティブ状態 --- */
        .dropdown-item.active,
        .nav-tab-item.active {
            background-color: transparent !important;
            color: var(--admin-text-light) !important;
            opacity: 1;
        }

        /* --- [Active Hover] アクティブ時のホバー --- */
        .nav-tab-item.active:hover,
        .dropdown-item.active:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: var(--admin-text-light) !important;
            opacity: 1;
        }

        /* ==================================================== */
        /* 3. モバイル表示ロジック (項目2の補助・切り替え) */
        /* ==================================================== */

        @media (max-width: 991.98px) {

            /* ボタンを消して、ドロップダウンの中身(ul)を常に表示する */
            #roomDropdownButton {
                display: none !important;
            }

            .custom-mobile-dropdown-menu.dropdown-menu {
                display: block !important;
                position: static !important;
                border: none !important;
                background-color: transparent !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .custom-mobile-dropdown-menu li {
                margin-top: 5px;
            }
        }

        @media (min-width: 992px) {

            /* PCではモバイル用メニュー設定を解除し、ボタンを表示 */
            .custom-mobile-dropdown-menu {
                display: none;
            }

            #roomDropdownButton {
                display: block !important;
            }
        }

        /* ==================================================== */
        /* 4. コンポーネント (カード・フォーム・画像など) */
        /* ==================================================== */

        /* カード */
        .card {
            background-color: var(--admin-header-bg);
            color: var(--admin-text-light);
            border: 1px solid #333;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* フォーム */
        .form-control,
        .form-select {
            background-color: #282834 !important;
            color: var(--admin-text-light) !important;
            border: 1px solid #4a4a58 !important;
        }

        input::placeholder,
        textarea::placeholder,
        select::placeholder {
            color: var(--admin-text-secondary) !important;
            opacity: 1;
        }

        /* パンくずリスト */
        .breadcrumb {
            --bs-breadcrumb-margin-bottom: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--admin-text-secondary) !important;
            transition: color 0.2s;
        }

        .breadcrumb-item a:hover {
            color: var(--admin-text-light) !important;
        }

        .breadcrumb-item.active {
            color: var(--admin-text-light) !important;
            font-weight: bold;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--admin-text-secondary);
        }

        /* ==================================================== */
        /* 5. 部屋カード (Room Card) アクション */
        /* ==================================================== */

        .room-card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* アクションボタンエリア */
        .room-action-area {
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 0.5rem 0;
        }

        .room-action-area .btn {
            border-radius: 0.5rem;
            background-color: transparent !important;
            font-weight: 500;
            transition: background-color 0.2s, border-color 0.2s, color 0.2s;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        /* 編集ボタン (一覧画面/カード内) */
        .room-action-area .btn-edit {
            color: var(--bs-primary) !important;
            border: 1px solid var(--bs-primary) !important;
        }

        .room-action-area .btn-edit:hover {
            background-color: var(--bs-primary) !important;
            color: var(--admin-header-bg) !important;
            filter: brightness(1) !important;
        }

        /* 削除ボタン (一覧画面/カード内) */
        .room-action-area .btn-delete {
            color: var(--bs-danger) !important;
            border: 1px solid var(--bs-danger) !important;
        }

        .room-action-area .btn-delete:hover {
            background-color: var(--bs-danger) !important;
            color: #ffffff !important;
            filter: brightness(1) !important;
        }

        /* PCサイズ時のレイアウト調整 (768px~) */
        @media (min-width: 768px) {
            .room-card-image {
                width: 200px;
                height: auto;
            }

            .room-action-area {
                width: 80px;
                flex-direction: column;
                border-top: none;
                border-left: 1px solid #333;
                justify-content: center;
                gap: 0.75rem;
                padding: 0.5rem 0;
            }

            .room-action-area .btn {
                width: 80%;
            }

            .admin-content {
                padding: 30px;
            }
        }

        /* ==================================================== */
        /* 6. 強制カラー上書き (Bootstrapクラス用) */
        /* ==================================================== */
        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        .btn-warning {
            background-color: var(--bs-warning) !important;
            border-color: var(--bs-warning) !important;
        }

        .btn-danger {
            background-color: var(--bs-danger) !important;
            border-color: var(--bs-danger) !important;
        }

        .btn-info {
            background-color: var(--bs-info) !important;
            border-color: var(--bs-info) !important;
        }

        .btn-sm {
            font-size: 0.95rem;
            padding: 0.35rem 0.75rem;
        }

        /* ---------------------------------------------------- */
        /* 7. ボタン幅の調整 (PC表示のみ) */
        /* ---------------------------------------------------- */
        @media (min-width: 576px) {

            /* 1. 200px に設定するグループ (更新, キャンセル, 詳細/一覧アクション) */
            .btn-update-w,
            /* カンマで区切る */
            .btn-cancel-w,
            /* カンマで区切る */
            .btn-show-back-w,
            .btn-show-edit-w,
            .btn-detail-w,
            .btn-edit-w {
                width: 200px !important;
                flex-shrink: 0;
            }

            /* 2. 120px に設定するグループ (削除ボタン) */
            .btn-delete-w {
                width: 120px !important;
                flex-shrink: 0;
            }
        }
    </style>


    @stack('styles')
</head>

<body>

    <header class="admin-header sticky-top">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container-fluid">

                {{-- サイトロゴ/タイトル --}}
                <a href="##" class="navbar-brand text-white text-decoration-none h4 fw-bold mb-0 me-3">
                    <i class="fas fa-hotel me-2 opacity-75"></i>予約管理システム
                </a>

                {{-- モバイル用トグルボタン (ハンバーガーメニュー) --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarContent" aria-controls="adminNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars text-white"></i>
                </button>

                {{-- 折りたたむナビゲーションコンテナ --}}
                <div class="collapse navbar-collapse" id="adminNavbarContent">

                    {{-- 内部のナビゲーションアイテムを横並びにするラッパー --}}
                    <div class="main-global-nav d-lg-flex gap-3">
                        {{-- ここには 'me-auto' は不要です --}}

                        {{-- 1. 予約一覧管理 --}}
                        <a href="##"
                            class="nav-tab-item py-1 px-3 rounded-3 fw-bold mt-2 mt-lg-0">
                            <i class="fas fa-calendar-alt me-2"></i> 予約一覧
                        </a>

                        {{-- 2. 部屋タイプ管理 (ドロップダウン) --}}
                        <div class="dropdown" id="roomDropdown">
                            <button class="nav-tab-item py-1 px-3 rounded-3 fw-bold dropdown-toggle mt-2 mt-lg-0"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false" id="roomDropdownButton">
                                <i class="fas fa-bed me-2"></i> 部屋タイプ管理
                            </button>

                            {{-- ★★★ ul要素に custom-mobile-dropdown-menu クラスがあることを確認 ★★★ --}}
                            <ul class="dropdown-menu dropdown-menu-dark custom-mobile-dropdown-menu" id="roomDropdownMenu">

                                {{-- 部屋タイプ一覧 --}}
                                <li><a class="dropdown-item @if(Request::routeIs('rooms.index')) active @endif"
                                        href="{{ route('admin.rooms.index') }}">
                                        <i class="fas fa-list me-2"></i> 部屋タイプ一覧
                                    </a></li>

                                {{-- 新規部屋タイプ登録 --}}
                                <li><a class="dropdown-item @if(Request::routeIs('rooms.create')) active @endif"
                                        href="{{ route('admin.rooms.create') }}">
                                        <i class="fas fa-plus-square me-2"></i> 新規部屋タイプ登録
                                    </a></li>
                            </ul>
                        </div>
                        {{-- グローバルナビゲーション終了 --}}
                    </div>

                    {{-- 右側: ログアウトボタン --}}
                    {{-- ★★★ 修正: ul 要素に ms-auto クラスを再適用 ★★★ --}}
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm rounded-3 px-3 d-flex align-items-center justify-content-center justify-content-lg-start">
                                    <i class="fas fa-sign-out-alt me-1"></i> ログアウト
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                {{-- /折りたたむナビゲーションコンテナ終了 --}}
        </nav>
    </header>

    {{-- ★★★ ページ固有のタイトル・戻るリンクエリアをヘッダー直下の別枠に配置 ★★★ --}}
    <div class="container-fluid py-3 px-4 page-header-area">
        <div class="d-flex justify-content-between align-items-center w-100">
            @yield('page_breadcrumb')
        </div>
    </div>

    <div class="container-fluid admin-content p-4">
        @yield('content')
    </div>


    {{-- ======================================================= --}}
    {{-- ★★★ 共通削除モーダルテンプレート ★★★ --}}
    {{-- ======================================================= --}}
    {{-- 各ページで削除ボタンを押した際、target="#deleteModal" でこのモーダルを呼び出し、 --}}
    {{-- JavaScriptでモーダルのフォーム action を動的に変更して使用します。 --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: var(--admin-header-bg);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel">削除の確認</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-white-75">
                        本当にこの<strong class="text-warning">データを削除</strong>してもよろしいですか？
                    </p>
                    <p class="text-danger small">
                        この操作は元に戻すことができません。
                    </p>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    {{-- 削除フォーム: 実際の削除URLはJavaScriptで設定されます --}}
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> 削除を実行
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ======================================================= --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // 1. 共通削除モーダルのアクション設定
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                // トリガーとなったボタン (削除ボタン)
                const button = event.relatedTarget;

                // 削除対象のURLを取得
                const deleteUrl = button.getAttribute('data-delete-url');

                // モーダル内のフォームの action 属性を設定
                const deleteForm = deleteModal.querySelector('#deleteForm');
                if (deleteForm && deleteUrl) {
                    deleteForm.setAttribute('action', deleteUrl);
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>