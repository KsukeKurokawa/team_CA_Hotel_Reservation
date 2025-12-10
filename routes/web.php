<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// http://127.0.0.1:8000/rooms
Route::prefix('admin/rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::match(['put', 'patch'], '{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});
