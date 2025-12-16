{{-- @extends('layouts.app') *共通レイアウトを使う --}}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>ログイン</h2>

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

        <form method="POST" action="{{ route('user.login') }}">
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

        <div class="mt-4 text-center">
            <p>アカウントをお持ちでない方は<a href="{{ route('register.form') }}" class="text-blue-600 hover:underline">こちら</a></p>
        </div>
    </div>
</body>
</html>