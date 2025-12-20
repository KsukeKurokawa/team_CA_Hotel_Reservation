<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
    <link rel="stylesheet" href="{{ asset('css/user-style.css') }}">
    <!-- Font Awesome（アイコン表示） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <h1 class="login-title"><i class="fas fa-hotel me-2 opacity-75"></i>一泊限定 高級宿泊施設予約</h1>

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