<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserArtikelController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
});

// 🔥 Ini DIPISAH dari admin
Route::prefix('user/artikel')->name('user.artikel.')->group(function () {
    Route::get('/', [UserArtikelController::class, 'index'])->name('index');
    Route::get('/{id}', [UserArtikelController::class, 'show'])->name('show');
});


