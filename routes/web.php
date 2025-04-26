<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetectionController;
use App\Http\Controllers\AuthController;

// Halaman awal redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Login dan Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route setelah login
Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Orangtua Dashboard
    Route::get('/user/dashboard', function () {
        if (auth()->user()->role !== 'orangtua') {
            abort(403);
        }
        return view('orangtua.dashboard');
    })->name('orangtua.dashboard');

    // Orangtua fitur deteksi
    Route::get('/orangtua/deteksi-stunting', [DetectionController::class, 'create'])->name('orangtua.detections.create');
    Route::post('/orangtua/deteksi-stunting', [DetectionController::class, 'store'])->name('orangtua.detections.store');

    // Admin fitur lihat semua deteksi
    Route::get('/admin/detections', [DetectionController::class, 'index'])->name('admin.detections.index');
});
