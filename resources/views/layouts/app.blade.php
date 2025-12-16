<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '高級宿泊施設予約')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- カスタムスタイル（必要なら） -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Helvetica Neue', sans-serif;
        }
        .header {
            background: linear-gradient(to right, #d4af37, #fff8dc);
            padding: 20px;
            text-align: center;
            color: #333;
        }
        .room-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            background-color: #fff;
        }
        .room-card.disabled {
            opacity: 0.5;
        }
    </style>
</head>
<body>

    <!-- ナビゲーション -->
    <nav class="bg-light border-bottom py-2 px-4 d-flex justify-content-end">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">ログアウト</button>
        </form>
    </nav>

    <!-- コンテンツ -->
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

