<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function show()
    {
        return view('auth.userlogin'); // ログイン画面
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt でログイン試行
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 権限チェック
            if ($user->role !== 'customer') {
                Auth::logout();
                return back()->withErrors([
                    'email' => '一般ユーザーとしての権限がありません',
                ]);
            }

            // ログイン成功 → 予約画面へ
            return redirect()->route('booking.create')->with('success', 'ログインしました');
        }

        // ログイン失敗
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません',
        ]);
    }
}
