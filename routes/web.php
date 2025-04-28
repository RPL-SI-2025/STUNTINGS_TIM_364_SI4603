<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\ImmunizationRecordController;
use App\Http\Controllers\TahapanPerkembanganController;
use App\Http\Controllers\TahapanPerkembanganDataController;

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


// Dashboard 
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->role !== 'admin') {
            abort(403); 
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/user/dashboard', function () {
        if (Auth::user()->role !== 'orangtua') {
            abort(403); 
        }
        return view('orangtua.dashboard'); //1
    })->name('orangtua.dashboard');
});

//master data
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('immunizations', ImmunizationController::class);
});
//record imunisasi
Route::middleware(['auth'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::resource('immunization_records', ImmunizationRecordController::class);
});
// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tahapan_perkembangan', TahapanPerkembanganController::class);
    Route::get('perkembangan/create', [TahapanPerkembanganController::class, 'create'])->name('perkembangan.create');
});

// User routes (Orang Tua)
Route::middleware(['auth'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::resource('tahapan_perkembangan', TahapanPerkembanganDataController::class);
    
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->middleware('role:admin');
//     Route::get('/orangtua/dashboard', fn() => view('orangtua.dashboard'))->middleware('role:orangtua');
// });



