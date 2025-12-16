<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'phone' => [
                'required',
                function ($attribute, $value, $fail) {
                    $numbersOnly = preg_replace('/[^0-9]/', '', $value);
                
                    if (strlen($numbersOnly) < 10 || strlen($numbersOnly) > 11) {
                        $fail('電話番号の形式が正しくありません。');
                    }
                },
            ],
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'phone'    => preg_replace('/[^0-9]/', '', $request->phone), // ハイフン削除
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.login.form')->with('success', '登録完了');
    }
}