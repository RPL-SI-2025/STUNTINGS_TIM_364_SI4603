<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\ImmunizationRecordController;

Route::get('/', function () {
    return redirect('/login');
});

// Login & Register
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
        return view('user.dashboard');
    })->name('orangtua.dashboard');
});

//master data
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('immunizations', ImmunizationController::class);
});
//record imunisasi
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('immunization_records', ImmunizationRecordController::class);
});
