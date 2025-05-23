<?php
use Illuminate\Http\Request;
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
use App\Http\Controllers\AdminDetectionController;

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
        return view('orangtua.dashboard'); //1
    })->name('orangtua.dashboard');
});

 // Orangtua fitur deteksi
 Route::get('/user/deteksi-stunting', [DetectionController::class, 'create'])->name('orangtua.detections.create');
 Route::post('/orangtua/deteksi-stunting', [DetectionController::class, 'store'])->name('orangtua.detections.store');

 // Admin fitur lihat semua deteksi
 Route::get('/admin/detections', [DetectionController::class, 'index'])->name('admin.detections.index');

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
//bmi
Route::get('/bmi', function () {return view('bmi');})->name('bmi');

Route::post('/hitung-bmi', [BMICalculatorController::class, 'calculate'])->name('hitung-bmi');
Route::post('/simpan-bmi', [BMICalculatorController::class, 'save'])->name('simpan-bmi');
Route::post('/reset-bmi', [BMICalculatorController::class, 'reset'])->name('reset-bmi');
Route::post('/hapus-bmi/{index}', [BMICalculatorController::class, 'deleteRow'])->name('hapus-bmi-row');
Route::get('/bmi', [BMICalculatorController::class, 'showBmiData'])->name('bmi');

// Route untuk ADMIN (CRUD data gizi)
Route::middleware(['auth'])->group(function () {
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('admin.nutrition.index');
    Route::get('/nutrition/create', [NutritionController::class, 'create'])->name('admin.nutrition.create');
    Route::post('/nutrition', [NutritionController::class, 'store'])->name('admin.nutrition.store');
    Route::get('/nutrition/{id}/edit', [NutritionController::class, 'edit'])->name('admin.nutrition.edit');
    Route::put('/nutrition/{id}', [NutritionController::class, 'update'])->name('admin.nutrition.update');
    Route::delete('/nutrition/{id}', [NutritionController::class, 'destroy'])->name('admin.nutrition.destroy');
});

// ORANGTUA (akses nutritionUs)
Route::middleware(['auth'])->group(function () {

    Route::get('/nutritionUs', function (Request $request) {
        // Role check supaya hanya orangtua yg bisa akses nutritionUs
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $kategori = $request->query('kategori');

        if ($kategori) {
            $menus = NutritionRecommendation::where('category', $kategori)->get();
        } else {
            $menus = NutritionRecommendation::all();
        }

        return view('nutritionUs.index', compact('menus', 'kategori'));
    })->name('nutritionUs.index');

    Route::get('/nutritionUs/{id}', function (string $id) {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $menu = NutritionRecommendation::findOrFail($id);
        return view('nutritionUs.show', compact('menu'));
    })->name('nutritionUs.show');
});



//artikel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
});

// artikel Ini DIPISAH dari admin
Route::prefix('user/artikel')->name('user.artikel.')->group(function () {
    Route::get('/', [UserArtikelController::class, 'index'])->name('index');
    Route::get('/{id}', [UserArtikelController::class, 'show'])->name('show');
});
//