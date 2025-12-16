<!-- resources/views/user/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>ユーザーダッシュボード</title>
</head>
<body>
    <h1>ユーザーログイン成功</h1>
    <p>この画面は仮のダッシュボードです。</p>
    
    <!-- セッション取得（仮） -->
    <p>name:{{ session('user')->name }}</p>
    <p>role: {{ session('user')->role }}</p>
    <p>status: {{ session('user')->status }}</p>
    
    <form method="POST" action="{{ route('user.logout') }}">
    @csrf
    <button type="submit">ログアウト</button>
    </form>
</body>
</html>
