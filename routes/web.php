<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminReservationController;

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
