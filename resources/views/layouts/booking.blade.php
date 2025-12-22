<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>高級宿泊施設予約システム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>
        /* タブ全体の基本デザイン */
        .nav-tabs .nav-link {
            font-size: 1.2rem;
            /* フォントサイズを大きく */
            padding: 12px 24px;
            /* 余白を広げて押しやすく */
            border-radius: 10px;
            /* 角丸 */
            margin-right: 10px;
            /* タブ間に余白 */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            /* 柔らかい影 */
            color: #333;
            /* 非アクティブ時の文字色 */
            background-color: #fff;
            /* 非アクティブ時の背景色 */
            border: 1px solid #ddd;
            /* 枠線を薄めに */
        }

        /* アクティブタブ */
        .nav-tabs .nav-link.active {
            background-color: #f5f5dc;
            /* ベージュ背景 */
            color: #8b4513;
            /* ブラウン文字 */
            border-color: #8b4513;
            /* 枠線もブラウン */
            font-weight: bold;
            /* 強調 */
        }

        /* ホバー時の効果 */
        .nav-tabs .nav-link:hover {
            background-color: #fdf5e6;
            /* 少し濃いベージュで反応 */
            color: #8b4513;
        }
    </style>

    <style>
        /* カードの高級感 */
        .card {
            border: 1px solid #d8c9a3;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background-color: #fff8dc;


        }

        .card-header {
            background: linear-gradient(to right, #3c2f2f, #5a4635);
            color: #f5f5dc;
            font-size: 1.4rem;
            font-weight: bold;

        }

        /* フォームラベルと入力欄の文字を大きく */
        label,
        .form-control {
            font-size: 1.2rem;
            /* 通常より少し大きめ */
            border-radius: 8px;
            /* 柔らかさを表現 */
        }

        /* 日付入力欄（カレンダー）のサイズを拡大 */
        input[type="date"] {
            font-size: 1.2rem;
            /* 文字を大きく */
            padding: 10px;
            /* 内側余白を広げる */
            height: 50px;
            /* 高さを指定して大きく */
        }


        /* ボタンの高級感 */
        .btn-luxury {
            background: linear-gradient(90deg, #8b4513, #d4af37);
            color: white;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: bold;
            border: none;
        }

        .btn-luxury:hover {
            opacity: 0.9;
        }


        /* 予約確定ボタンを目立たせる */
        #reserveBtn {
            background-color: #28a745;
            /* 緑色 */
            color: #fff;
            /* 白文字 */
            font-size: 1.2rem;
            /* 文字を大きく */
            padding: 12px 24px;
            /* ボタンを大きく */
            border-radius: 8px;
            /* 角丸 */
            transition: background-color 0.3s ease;
        }

        /* ホバー時の効果 */
        #reserveBtn:hover {
            background-color: #218838;
            /* 少し濃い緑に */
        }

        /* 押せない時（disabled） */
        #reserveBtn:disabled {
            background-color: #c3e6cb;
            /* 薄い緑 */
            color: #6c757d;
            /* グレー文字 */
            cursor: not-allowed;
            /* 押せないカーソル */
            opacity: 0.7;
            /* 少し透明に */
        }

        .total-price {
            font-size: 2rem;
            /* 大きな文字 */
            font-weight: bold;
            /* 太字 */
            color: #8b0000;
            /* 濃い赤で強調 */
            background-color: #fff0e6;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);

        }

        /* PC のときだけ予約フォームを左に寄せる */
        @media (min-width: 992px) {
            .booking-left {
                margin-left: -80px;
                /* 左に寄せる量は調整可能 */
            }

            /* 右側に余白を追加してバランス調整 */
            .booking-right {
                padding-left: 40px;
 
            }
        }

        /* 横幅を広くして中央寄せ */
        @media (min-width: 992px) {
            .room-card {
                max-width: 900px;                
                margin: 0 auto;
            }
        }


        html {
            overflow-y: scroll;
        }

        .tab-content {
            min-height: 600px;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 1rem;
            font-size: 1.1rem;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #fdf5e6;
        }
    </style>


</head>

<body style="background-color: #f5f5dc;">

    <!-- ログアウトボタンページ名とユーザー名 -->
    <header class="text-center py-4 mb-5"
        style="background: linear-gradient(to right, #d4af37, #fff8dc); color:#3c2f2f;">
        <form action="{{ route('logout') }}" method="POST" style="position: absolute; top: 10px; right: 20px;">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> ログアウト
            </button>
        </form>

        <!-- ページ名とユーザー名 -->
        <h1 class="display-5 fw-bold">一泊限定 高級宿泊施設予約</h1>
        <h2 class="fs-4 text-dark mt-2">
            @if (auth()->check())
                ようこそ、{{ Auth::user()->name }}様
            @else
                ようこそ、ゲスト様
            @endif
        </h2>
    </header>

    {{-- コンテンツ部分 --}}
    <main class="container">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    // モーダル表示時に Bootstrap が追加する padding-right をリアルタイムで消す
    const fixModalShift = () => {
        document.body.style.paddingRight = '0px';
        document.documentElement.style.paddingRight = '0px';
    };

    document.addEventListener('shown.bs.modal', fixModalShift);
    document.addEventListener('hidden.bs.modal', fixModalShift);
</script>



</body>

</html>
