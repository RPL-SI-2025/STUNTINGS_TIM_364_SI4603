<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    AuthController,
    ArtikelController,
    ArtikelKategoriController,
    DetectionController,
    AdminDetectionController,
    ImmunizationController,
    ImmunizationRecordController,
    TahapanPerkembanganController,
    TahapanPerkembanganDataController,
    BMICalculatorController,
    NutritionController,
    UserArtikelController
};
use App\Models\NutritionRecommendation;

/*
|--------------------------------------------------------------------------
| Auth & Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', fn () => Auth::user()->role !== 'admin' ? abort(403) : view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/user/dashboard', fn () => Auth::user()->role !== 'orangtua' ? abort(403) : view('orangtua.dashboard'))->name('orangtua.dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Artikel dan Kategori
    Route::prefix('artikel')->name('artikel.')->group(function () {
        Route::resource('/', ArtikelController::class)->parameters(['' => 'artikel'])->except(['show']);
        Route::get('/show/{id}', [ArtikelController::class, 'show'])->name('show');
        Route::resource('kategori', ArtikelKategoriController::class)->except(['show']);
    });

    // Deteksi dan Tahapan
    Route::get('/detections', [DetectionController::class, 'index'])->name('detections.index');
    Route::resource('tahapan_perkembangan', TahapanPerkembanganController::class);
    Route::get('perkembangan/create', [TahapanPerkembanganController::class, 'create'])->name('perkembangan.create');

    // Imunisasi
    Route::resource('immunizations', ImmunizationController::class);
});

/*
|--------------------------------------------------------------------------
| Orangtua / User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::resource('immunization_records', ImmunizationRecordController::class);
    Route::resource('tahapan_perkembangan', TahapanPerkembanganDataController::class);

    Route::get('/deteksi-stunting', [DetectionController::class, 'create'])->name('detections.create');
    Route::post('/deteksi-stunting', [DetectionController::class, 'store'])->name('detections.store');

    // Artikel untuk orangtua
    Route::prefix('artikel')->name('artikel.')->group(function () {
        Route::get('/', [UserArtikelController::class, 'index'])->name('index');
        Route::get('/{id}', [UserArtikelController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Nutrition
|--------------------------------------------------------------------------
*/
Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
Route::get('/nutrition/create', [NutritionController::class, 'create'])->name('nutrition.create');
Route::post('/nutrition', [NutritionController::class, 'store'])->name('nutrition.store');
Route::get('/nutrition/{id}/edit', [NutritionController::class, 'edit'])->name('nutrition.edit');
Route::put('/nutrition/{id}', [NutritionController::class, 'update'])->name('nutrition.update');
Route::delete('/nutrition/{id}', [NutritionController::class, 'delet'])->name('nutrition.delet');

Route::get('/nutritionUs', fn () => view('nutritionUs.index', ['menus' => NutritionRecommendation::all()]))->name('nutritionUs.index');
Route::get('/nutritionUs/{id}', fn (string $id) => view('nutritionUs.show', ['menu' => NutritionRecommendation::find($id)]))->name('nutritionUs.show');

/*
|--------------------------------------------------------------------------
| BMI
|--------------------------------------------------------------------------
*/
Route::get('/bmi', [BMICalculatorController::class, 'showBmiData'])->name('bmi');
Route::post('/hitung-bmi', [BMICalculatorController::class, 'calculate'])->name('hitung-bmi');
Route::post('/simpan-bmi', [BMICalculatorController::class, 'save'])->name('simpan-bmi');
Route::post('/reset-bmi', [BMICalculatorController::class, 'reset'])->name('reset-bmi');
Route::post('/hapus-bmi/{index}', [BMICalculatorController::class, 'deleteRow'])->name('hapus-bmi-row');

//filter kategori
Route::get('/admin/artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');

