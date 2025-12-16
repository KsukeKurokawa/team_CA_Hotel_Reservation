<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SimpleLoginController extends Controller
{
    public function showForm()
    {
        return view('booking.login-simple');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        Auth::login($user);

        return redirect()->route('booking.create')->with('success', 'ログインしました');
    }
}
