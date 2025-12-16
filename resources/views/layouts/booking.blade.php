<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>高級宿泊施設予約システム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      /* タブ全体の基本デザイン */
      .nav-tabs .nav-link {
        font-size: 1.2rem;          /* フォントサイズを大きく */
        padding: 12px 24px;         /* 余白を広げて押しやすく */
        border-radius: 10px;        /* 角丸 */
        margin-right: 10px;         /* タブ間に余白 */
        box-shadow: 0 2px 6px rgba(0,0,0,0.15); /* 柔らかい影 */
        color: #333;                /* 非アクティブ時の文字色 */
        background-color: #fff;     /* 非アクティブ時の背景色 */
        border: 1px solid #ddd;     /* 枠線を薄めに */
      }

      /* アクティブタブ */
      .nav-tabs .nav-link.active {
        background-color: #f5f5dc;  /* ベージュ背景 */
        color: #8b4513;             /* ブラウン文字 */
        border-color: #8b4513;      /* 枠線もブラウン */
        font-weight: bold;          /* 強調 */
      }

      /* ホバー時の効果 */
      .nav-tabs .nav-link:hover {
        background-color: #fdf5e6;  /* 少し濃いベージュで反応 */
        color: #8b4513;
      }
    </style>

    <style>
  /* フォームラベルと入力欄の文字を大きく */
  label, .form-control {
    font-size: 1.2rem;   /* 通常より少し大きめ */
  }

  /* 日付入力欄（カレンダー）のサイズを拡大 */
  input[type="date"] {
    font-size: 1.2rem;   /* 文字を大きく */
    padding: 10px;       /* 内側余白を広げる */
    height: 50px;        /* 高さを指定して大きく */
  }

  /* 予約確定ボタンを目立たせる */
  #reserveBtn {
    background-color: #28a745; /* 緑色 */
    color: #fff;               /* 白文字 */
    font-size: 1.2rem;         /* 文字を大きく */
    padding: 12px 24px;        /* ボタンを大きく */
    border-radius: 8px;        /* 角丸 */
    transition: background-color 0.3s ease;
  }

  /* ホバー時の効果 */
  #reserveBtn:hover {
    background-color: #218838; /* 少し濃い緑に */
  }
  /* 押せない時（disabled） */
#reserveBtn:disabled {
  background-color: #c3e6cb; /* 薄い緑 */
  color: #6c757d;            /* グレー文字 */
  cursor: not-allowed;       /* 押せないカーソル */
  opacity: 0.7;              /* 少し透明に */
}

.total-price {
  font-size: 2rem;       /* 大きな文字 */
  font-weight: bold;     /* 太字 */
  color: #8b0000;        /* 濃い赤で強調 */
  margin-top: 10px;
}


</style>


</head>
<body style="background-color: #f5f5dc;">

    {{-- ログアウト --}}
    <nav style="background:#eee; padding:10px;">


        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">ログアウト</button>
        </form>
    </nav>

            <!-- ページ名とユーザー名 -->
            <header class="mt-2 mb-5">
            <h1 class="display-4 fw-bold">一泊限定 高級宿泊施設予約</h1>
            <h2 class="display-7 text-dark mt-2">
              @if(auth()->check())
                  ようこそ、{{ Auth::user()->name }}様
              @else
                  ようこそ、ゲスト様
              @endif
            </h2>
        </header>

    {{-- コンテンツ部分 --}}
    <main style="container">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
