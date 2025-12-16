<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Laravel予約システム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- CSSやJSは一旦読み込まない（@vite削除） --}}
</head>
<body class="bg-gray-100">
    {{-- ログアウト --}}
    <nav style="background:#eee; padding:10px;">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">ログアウト</button>
        </form>
    </nav>

    {{-- コンテンツ部分 --}}
    <main style="padding:20px;">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
