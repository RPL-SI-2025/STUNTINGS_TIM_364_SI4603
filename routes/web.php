<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BMICalculatorController;
Route::get('/', function () {
    return redirect('/login');
});


Route::get('/bmi', function () {
    return view('bmi');
})->name('bmi');

Route::post('/hitung-bmi', [BMICalculatorController::class, 'calculate'])->name('hitung-bmi');
Route::post('/simpan-bmi', [BMICalculatorController::class, 'save'])->name('simpan-bmi');
Route::post('/reset-bmi', [BMICalculatorController::class, 'reset'])->name('reset-bmi');
Route::post('/hapus-bmi/{index}', [BMICalculatorController::class, 'deleteRow'])->name('hapus-bmi-row');
Route::get('/bmi', [BMICalculatorController::class, 'showBmiData'])->name('bmi');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->middleware('role:admin');
//     Route::get('/orangtua/dashboard', fn() => view('orangtua.dashboard'))->middleware('role:orangtua');
// });


