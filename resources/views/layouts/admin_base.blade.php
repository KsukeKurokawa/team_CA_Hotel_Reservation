<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '管理画面') | 宿泊予約管理システム</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

    <style>
        /* ---------------------------------------------------- */
        /* 1. 全てのカスタムCSS変数の定義とBootstrapの上書きを統合 */
        /* ---------------------------------------------------- */
        :root {
            /* ベースカラー */
            --admin-bg-dark: #12121c;
            /* より深い背景色 */
            --admin-header-bg: #1e1e2d;
            /* わずかに明るいカード/ヘッダー背景 */
            --admin-text-light: #e0e0e0;
            /* 明るいテキスト */
            --admin-text-secondary: #a0a0a0;
            /* セカンダリテキスト */

            /* ---------------------------------------------------- */
            /* Bootstrap変数の上書き（モダンなカスタムカラーを適用） */
            /* ---------------------------------------------------- */

            /* プライマリー (btn-primary) - モダンな青 */
            --bs-primary: #4080c9ff;
            --bs-primary-rgb: 74, 144, 226;
            --admin-accent: var(--bs-primary);
            /* btn-primaryなどで使用 */

            /* 警告色 (btn-warning) - デジタルなゴールドオレンジ */
            --bs-warning: #c5820fff;
            --bs-warning-rgb: 245, 166, 35;

            /* 危険色 (btn-danger) - クリアな赤 */
            --bs-danger: #b8091eff;
            --bs-danger-rgb: 208, 2, 27;

            /* 情報色 (btn-info / 素泊まりプラン) - ミントグリーン系 */
            --bs-info: #49cfb2ff;
            --bs-info-rgb: 80, 227, 194;

            .btn:hover {
                /* filter: brightness(1.15); をより確実に適用するため、重要度を上げる */
                filter: brightness(1.15) !important;
                color: #ffffff !important;
                /* マウスを乗せてもボタンが動かないようにする */
                transform: none !important;
            }

            body {
                background-color: var(--admin-bg-dark);
                color: var(--admin-text-light);
                min-height: 100vh;
                font-size: 1.1rem;
                font-family: 'Noto Sans JP', sans-serif !important;
                background-color: var(--admin-bg-dark);
                color: var(--admin-text-light);
                min-height: 100vh;
                font-size: 1.1rem;
            }

            /* ヘッダー内のナビゲーションエリア (左側: 2段構成の親要素) */
            .header-nav-area {
                color: var(--admin-text-light);
                display: flex;
                flex-direction: column;
                line-height: 1.2;
            }

            /* 戻るリンク (下段) */
            .header-back-link {
                display: inline-flex;
                align-items: center;
                color: var(--admin-text-light) !important;
                text-decoration: none;
                opacity: 0.7;
                font-size: 0.85rem;
                margin-top: 10px;
                margin-bottom: 3px;
            }

            /* ---------------------------------------------------- */
            /* 2. ヘッダー/ナビゲーションの調整 */
            /* ---------------------------------------------------- */
            .admin-header {
                background-color: var(--admin-header-bg);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
                padding: 1rem 1rem;
            }

            .header-page-title {
                font-size: 1.5rem;
                font-weight: 700;
                margin: 0;
            }

            /* ---------------------------------------------------- */
            /* 3. カード/ボタンの調整 */
            /* ---------------------------------------------------- */

            .card {
                background-color: var(--admin-header-bg);
                /* 背景色をheaderと同じにして、影で立体感を出す */
                color: var(--admin-text-light);
                border: 1px solid #333;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }

            /* .btn-primary はカスタム変数に依存 */
            .btn-primary {
                background-color: var(--admin-accent);
                border-color: var(--admin-accent);
                font-weight: 500;
                transition: background-color 0.2s;
            }

            .btn-sm {
                /* font-size: 0.875rem (Bootstrap標準) から 0.95rem へ */
                font-size: 0.95rem;
                padding: 0.35rem 0.75rem;
            }

            /* ---------------------------------------------------- */
            /* 4. 画像とアクションエリア (room-card) の調整 */
            /* ---------------------------------------------------- */

            .room-card-image {
                width: 100%;
                height: 200px;
            }

            .room-action-area {
                width: 100%;
                flex-direction: row;
                border-top: 1px solid #333;
            }

            /* ---------------------------------------------------- */
            /* 5. フォーム要素のスタイル */
            /* ---------------------------------------------------- */

            /* フォーム要素の統一的な背景とテキストカラー */
            .form-control,
            .form-select {
                background-color: #282834 !important;
                color: var(--admin-text-light) !important;
                border: 1px solid #4a4a58 !important;
            }

            /* プレースホルダーの修正 */
            input::placeholder,
            textarea::placeholder,
            select::placeholder {
                color: var(--admin-text-secondary) !important;
                opacity: 1;
            }

            input::-webkit-input-placeholder,
            textarea::-webkit-input-placeholder,
            select::-webkit-input-placeholder,
            input:-moz-placeholder,
            textarea:-moz-placeholder,
            select:-moz-placeholder {
                color: var(--admin-text-secondary) !important;
            }

            /* ---------------------------------------------------- */
            /* PC・タブレット用（768px以上）のスタイル上書き */
            /* ---------------------------------------------------- */
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
                }

                .admin-content {
                    padding: 30px;
                }
            }

            /* ---------------------------------------------------- */
            /* ★色の強制適用ルール (最終手段 - !importantで色を確定)★ */
            /* ---------------------------------------------------- */

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
    </style>


    @stack('styles')
</head>

<body>

    <header class="admin-header sticky-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">

                <div class="header-nav-area">
                    {{-- 子ビューがこのセクションで戻るリンクとタイトルを挿入します --}}
                    @yield('page_breadcrumb')
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST" action="#">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container-fluid admin-content p-4">

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @stack('scripts')
</body>

</html>