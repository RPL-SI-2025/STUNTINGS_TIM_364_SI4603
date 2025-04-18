<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetectionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDetectionController;

Route::get('/', function () {
    return redirect('/login');
});

// Login dan register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk user biasa (orang tua)
Route::middleware(['auth'])->group(function () {
    Route::get('/deteksi-stunting', [DetectionController::class, 'create'])->name('deteksi.create');
    Route::post('/deteksi-stunting', [DetectionController::class, 'store'])->name('deteksi.store');
});

// Route untuk admin
Route::middleware('admin')->group(function () {
    Route::get('/admin/detections', [AdminDetectionController::class, 'index'])->name('admin.detections');
});
            

