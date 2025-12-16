{{-- @extends('layouts.app') *共通レイアウトを使う --}}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>アカウント作成</h2>

        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="form-group">
                <label>名前</label>
                <input type="text" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>電話番号</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>パスワード (8文字以上)</label>
                <input type="password" name="password">
            </div>

            <div class="form-group">
                <label>パスワード（確認）</label>
                <input type="password" name="password_confirmation">
            </div>

            <div>
                <button type="submit">アカウント登録</button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <p>すでにアカウントをお持ちの方は<a href="{{ route('user.login.form') }}" class="text-blue-600 hover:underline">こちら</a></p>
        </div>
    </div>
</body>
</html>