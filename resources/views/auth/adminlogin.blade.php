{{-- @extends('layouts.app') *共通レイアウトを使う --}}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>管理者ログイン</h2>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @if (session('success'))
            <p style="color: green; margin-bottom: 20px;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <button type="submit">ログイン</button>
            </div>
        </form>
    </div>
</body>
</html>