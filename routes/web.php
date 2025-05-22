<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\ImmunizationRecordController;
use App\Http\Controllers\TahapanPerkembanganController;
use App\Http\Controllers\TahapanPerkembanganDataController;
use App\Http\Controllers\BMICalculatorController;
use App\Http\Controllers\NutritionController;
use App\Models\NutritionRecommendation;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserArtikelController;
use App\Http\Controllers\DetectionController;

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

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Data imunisasi
        Route::resource('immunizations', ImmunizationController::class);

        // Tahapan perkembangan
        Route::resource('tahapan_perkembangan', TahapanPerkembanganController::class);
        Route::get('perkembangan/create', [TahapanPerkembanganController::class, 'create'])->name('perkembangan.create');

        // Deteksi dari semua user
        Route::get('/detections', [DetectionController::class, 'index'])->name('detections.index');

        // Artikel
        Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
        Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
        Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
        Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
        Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
        Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    });

    // Orangtua routes
    Route::prefix('orangtua')->name('orangtua.')->group(function () {
        // Deteksi stunting
        Route::get('/deteksi-stunting', [DetectionController::class, 'create'])->name('detections.create');
        Route::post('/deteksi-stunting', [DetectionController::class, 'store'])->name('detections.store');
        Route::delete('/detections/{id}', [DetectionController::class, 'destroy'])->name('detections.destroy');

        // Record imunisasi
        Route::resource('immunization_records', ImmunizationRecordController::class);

        // Tahapan perkembangan anak
        Route::resource('tahapan_perkembangan', TahapanPerkembanganDataController::class);

        // Artikel user
        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/', [UserArtikelController::class, 'index'])->name('index');
            Route::get('/{id}', [UserArtikelController::class, 'show'])->name('show');
        });
    });
});

// BMI
Route::get('/bmi', [BMICalculatorController::class, 'showBmiData'])->name('bmi');
Route::post('/hitung-bmi', [BMICalculatorController::class, 'calculate'])->name('hitung-bmi');
Route::post('/simpan-bmi', [BMICalculatorController::class, 'save'])->name('simpan-bmi');
Route::post('/reset-bmi', [BMICalculatorController::class, 'reset'])->name('reset-bmi');
Route::post('/hapus-bmi/{index}', [BMICalculatorController::class, 'deleteRow'])->name('hapus-bmi-row');

// Nutrition Admin
Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
Route::get('/nutrition/create', [NutritionController::class, 'create'])->name('nutrition.create');
Route::post('/nutrition', [NutritionController::class, 'store'])->name('nutrition.store');
Route::get('/nutrition/{id}/edit', [NutritionController::class, 'edit'])->name('nutrition.edit');
Route::put('/nutrition/{id}', [NutritionController::class, 'update'])->name('nutrition.update');
Route::delete('/nutrition/{id}', [NutritionController::class, 'delet'])->name('nutrition.delet'); // typo di "delet" seharusnya "destroy" ?

// Nutrition User
Route::get('/nutritionUs', function () {
    $menus = NutritionRecommendation::all();
    return view('nutritionUs.index', compact('menus'));
})->name('nutritionUs.index');

Route::get('/nutritionUs/{id}', function (string $id) {
    $menu = NutritionRecommendation::find($id);
    return view('nutritionUs.show', compact('menu'));
})->name('nutritionUs.show');
