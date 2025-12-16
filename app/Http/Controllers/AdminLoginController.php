<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AdminLoginController extends Controller
{
    public function show()
    {
        return view('auth.adminlogin'); // ビュー名は登録と合わせてauthフォルダに
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // emailでユーザーを検索
        $user = User::where('email', $request->email)->first();

        // ユーザーが存在しない
        if (!$user) {
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません',
            ]);
        }

        // パスワードの照合
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません',
            ]);
        }

        // 管理者権限チェック（role='admin'）
        if ($user->role !== 'admin') {
            return back()->withErrors([
                'email' => '管理者権限がありません',
            ]);
        }

        // セッションに保存（パスワードは除外）
        // $user->makeHidden('password');
        session(['admin' => $user]);
        // Log::info('Session saved:', ['user' => session('user')]);
        // dd('Login処理完了', session('user')); // ここで止める

        // セッションIDを新しく生成
        $request->session()->regenerate();
        
        // 管理者用ダッシュボードへ
        return redirect()->intended('/admin/dashboard'); 
    }
}
