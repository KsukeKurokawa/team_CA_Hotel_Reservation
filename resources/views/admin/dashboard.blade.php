<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>管理者ダッシュボード</title>
</head>
<body>
    <h1>管理者ログイン成功</h1>
    <p>この画面は仮のダッシュボードです。</p>

    <!-- セッション取得（仮） -->
    <p>name:{{ session('user')->name }}</p>
    <p>role: {{ session('user')->role }}</p>
    <p>status: {{ session('user')->status }}</p>
    
    <form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit">ログアウト</button>
    </form>
</body>
</html>
