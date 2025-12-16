<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\AdminLoginController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/reservations', [AdminReservationController::class, 'index'])
    ->name('admin.reservations.index');

Route::get('/admin/reservations/{reservation}/edit', [AdminReservationController::class, 'edit'])
    ->name('admin.reservations.edit');

Route::put('/admin/reservations/{reservation}', [AdminReservationController::class, 'update'])
    ->name('admin.reservations.update');

Route::delete('/admin/reservations/{reservation}', [AdminReservationController::class, 'destroy'])
    ->name('admin.reservations.destroy');


/*========================================
 ユーザー予約関連
 =======================================*/

// 仮のログイン画面
Route::get('/login-simple', [SimpleLoginController::class, 'showForm'])->name('login.simple');
Route::post('/login-simple', [SimpleLoginController::class, 'login']);


/*一旦保留するルート

// 予約フォーム表示（チェックイン日を選択したときもここに戻る）
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');

// 予約保存（フォーム送信）
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

*/

// 予約一覧表示（タブの「予約一覧」で利用）
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');

// 予約フォーム＋一覧（タブ切り替え）
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

// 予約保存（フォーム送信）
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// 予約キャンセル（一覧からキャンセルボタンを押したとき）
Route::delete('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');


// 予約キャンセル（一覧からキャンセルボタンを押したとき）
Route::delete('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');


Route::get('/booking/complete', [BookingController::class, 'complete'])->name('booking.complete');

// 会員管理
Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');

// ログアウト処理
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login-simple'); // ログアウト後のリダイレクト先
})->name('logout');

