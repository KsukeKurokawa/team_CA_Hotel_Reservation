<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// http://127.0.0.1:8000/rooms
Route::prefix('rooms')->group(function () {
    // 作成中
    Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
    // 作成済み
    Route::get('create', [RoomController::class, 'create'])->name('rooms.create');
    // 作成済み
    Route::post('/', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::match(['put', 'patch'], '{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});
