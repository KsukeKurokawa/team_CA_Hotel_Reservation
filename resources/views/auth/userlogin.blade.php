<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/user-style.css') }}">
    <!-- Font Awesome（アイコン表示） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <h1 class="login-title"><i class="fas fa-hotel me-2 opacity-75"></i>一泊限定 高級宿泊施設予約</h1>

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