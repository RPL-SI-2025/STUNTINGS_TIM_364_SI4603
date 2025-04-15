<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetectionController;

// Tampilkan form deteksi stunting
Route::get('/deteksi-stunting', [DetectionController::class, 'create'])->name('deteksi.create');

// Proses data deteksi dari form
Route::post('/deteksi-stunting', [DetectionController::class, 'store'])->name('deteksi.store');

// Lihat hasil deteksi dari sisi admin
Route::get('/admin/detections', function () {
    return \App\Models\Detection::all();
});

// Landing page
Route::get('/', function () {
    return redirect('/login');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->middleware('role:admin');
//     Route::get('/orangtua/dashboard', fn() => view('orangtua.dashboard'))->middleware('role:orangtua');
// });


