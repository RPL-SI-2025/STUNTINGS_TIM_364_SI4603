<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\ImmunizationRecordController;
use App\Http\Controllers\TahapanPerkembanganController;
use App\Http\Controllers\TahapanPerkembanganDataController;
use App\Http\Controllers\BMICalculatorController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\UserArtikelController;
use App\Http\Controllers\DetectionController;
use App\Http\Controllers\AdminDetectionController;

use App\Models\NutritionRecommendation;

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

    Route::get('/orangtua/dashboard', function () {
        if (Auth::user()->role !== 'orangtua') {
            abort(403);
        }
        return view('orangtua.dashboard');
    })->name('orangtua.dashboard');
});

// Deteksi Stunting (Orangtua)
Route::get('/user/deteksi-stunting', [DetectionController::class, 'create'])->name('orangtua.detections.create');
Route::post('/orangtua/deteksi-stunting', [DetectionController::class, 'store'])->name('orangtua.detections.store');

// Deteksi Stunting (Admin)
Route::get('/admin/detections', [DetectionController::class, 'index'])->name('admin.detections.index');

// Master Data (Admin)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('immunizations', ImmunizationController::class);
    Route::resource('tahapan_perkembangan', TahapanPerkembanganController::class);
    Route::get('perkembangan/create', [TahapanPerkembanganController::class, 'create'])->name('perkembangan.create');
    Route::resource('nutrition', NutritionController::class)->except(['show']);
});

// Record Imunisasi (Orangtua)
Route::middleware(['auth'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::resource('immunization_records', ImmunizationRecordController::class);
    Route::resource('tahapan_perkembangan', TahapanPerkembanganDataController::class);
});

// BMI Calculator
Route::get('/bmi', [BMICalculatorController::class, 'showBmiData'])->name('bmi');
Route::post('/hitung-bmi', [BMICalculatorController::class, 'calculate'])->name('hitung-bmi');
Route::post('/simpan-bmi', [BMICalculatorController::class, 'save'])->name('simpan-bmi');
Route::post('/reset-bmi', [BMICalculatorController::class, 'reset'])->name('reset-bmi');
Route::post('/hapus-bmi/{index}', [BMICalculatorController::class, 'deleteRow'])->name('hapus-bmi-row');

// Artikel
// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('artikel', ArtikelController::class);
});
Route::resource('artikel', ArtikelController::class)->except(['show']);


// Orangtua (Nutrition Recommendation View)
Route::middleware(['auth'])->group(function () {

    Route::get('/nutritionUs', function (Request $request) {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $kategori = $request->query('kategori');
        $menus = $kategori
            ? NutritionRecommendation::where('category', $kategori)->get()
            : NutritionRecommendation::all();

        return view('nutritionUs.index', compact('menus', 'kategori'));
    })->name('nutritionUs.index');

    Route::get('/nutritionUs/{id}', function (string $id) {
        $menu = NutritionRecommendation::findOrFail($id);
        return view('nutritionUs.show', compact('menu'));
    })->name('nutritionUs.show');

});
