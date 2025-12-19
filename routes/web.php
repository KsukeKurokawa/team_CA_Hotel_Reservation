<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MemberController;

//仮のログイン画面用
use App\Http\Controllers\SimpleLoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/*========================================
 ユーザー
 =======================================*/

// --- login ---
// アカウント登録
Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// ユーザーログイン
Route::get('/login', [UserLoginController::class, 'show'])->name('user.login.form');
Route::post('/login', [UserLoginController::class, 'login'])->name('user.login');

//// ログイン後の仮画面表示
Route::get('/user/dashboard', function () {
    if (!session()->has('user')) {
        return redirect('/login');
    }

    return view('user.dashboard');
});

//// ログアウト処理（仮）
Route::post('/user/logout', function () {
    session()->flush(); // 全セッションを削除
    return redirect('/login');
})->name('user.logout');



// --- 仮のlogin ---
// 仮のログイン画面
Route::get('/login-simple', [SimpleLoginController::class, 'showForm'])->name('login.simple');
Route::post('/login-simple', [SimpleLoginController::class, 'login']);


// --- user_booking ---



// 予約一覧表示（タブの「予約一覧」で利用）
Route::get('/booking', [BookingController::class, 'index'])
    ->name('booking.index');

// 予約フォーム＋一覧（タブ切り替え）
// /bookingから/booking/create に修正しました。
Route::get('/booking/create', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.create');

// 予約保存（フォーム送信）
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// 予約キャンセル（一覧からキャンセルボタンを押したとき）
Route::delete('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

// 予約完了画面の表示
Route::get('/booking/complete', [BookingController::class, 'complete'])->name('booking.complete');

// 会員管理
Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');

// ログアウト処理
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login'); // ログアウト後のリダイレクト先
})->name('logout');


/*========================================
 管理者
 =======================================*/

// --- login ---
// 管理者ログイン（外）
Route::get('/admin/login', [AdminLoginController::class, 'show'])->name('admin.login.form');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

// 管理者ログイン（中）
Route::middleware('admin')->group(function () {

    // ログイン後の入口
    Route::get('/admin/dashboard', function () {
        return redirect()->route('admin.rooms.index');
    });


    // --- reservations ---
    Route::prefix('admin/reservations')->group(function () {

        Route::get('/', [AdminReservationController::class, 'index'])
            ->name('admin.reservations.index');

        Route::get('{reservation}/edit', [AdminReservationController::class, 'edit'])
            ->name('admin.reservations.edit');

        Route::put('{reservation}', [AdminReservationController::class, 'update'])
            ->name('admin.reservations.update');

        Route::delete('{reservation}', [AdminReservationController::class, 'destroy'])
            ->name('admin.reservations.destroy');
    });


    // --- rooms ---
    Route::prefix('admin/rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('admin.rooms.index');
        Route::get('create', [RoomController::class, 'create'])->name('admin.rooms.create');
        Route::post('/', [RoomController::class, 'store'])->name('admin.rooms.store');

        Route::get('{room}', [RoomController::class, 'show'])->name('admin.rooms.show');
        Route::get('{room}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
        Route::put('{room}', [RoomController::class, 'update'])->name('admin.rooms.update');
        Route::delete('{room}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');
    });


    //// ログアウト処理（仮）
    Route::post('/admin/logout', function () {
        session()->flush(); // 全セッションを削除
        return redirect('/admin/login');
    })->name('admin.logout');

});




