<?php
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return redirect('/login');
});

// Auth
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
Route::middleware(['auth'])->group(function () {
    Route::get('/orangtua/deteksi-stunting', [DetectionController::class, 'create'])->name('orangtua.detections.create');
    Route::post('/orangtua/deteksi-stunting', [DetectionController::class, 'store'])->name('orangtua.detections.store');
    Route::delete('/orangtua/deteksi-stunting/{id}', [DetectionController::class, 'destroy'])->name('orangtua.detections.destroy');
});

// Deteksi Stunting (Admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/deteksi-stunting', [DetectionController::class, 'index'])->name('admin.detections.index');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 🔹 Kategori Artikel
    Route::prefix('artikel/kategori')->name('artikel.kategori.')->group(function () {
        Route::get('/', [ArtikelKategoriController::class, 'index'])->name('index');
        Route::get('/create', [ArtikelKategoriController::class, 'create'])->name('create');
        Route::post('/', [ArtikelKategoriController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [ArtikelKategoriController::class, 'edit'])->name('edit');
        Route::put('/{kategori}', [ArtikelKategoriController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [ArtikelKategoriController::class, 'destroy'])->name('destroy');
    });

    // 🔹 Artikel CRUD lengkap
    Route::prefix('artikel')->name('artikel.')->group(function () {
        Route::get('/', [ArtikelController::class, 'index'])->name('index');
        Route::get('/create', [ArtikelController::class, 'create'])->name('create');
        Route::post('/', [ArtikelController::class, 'store'])->name('store');
        Route::get('/{id}', [ArtikelController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ArtikelController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ArtikelController::class, 'update'])->name('update');
        Route::delete('/{id}', [ArtikelController::class, 'destroy'])->name('destroy');
    });

    // 🔹 Imunisasi
    Route::resource('immunizations', ImmunizationController::class); 

    // 🔹 Tahapan Perkembangan
    Route::resource('tahapan_perkembangan', TahapanPerkembanganController::class);
    
    // (Opsional) Jika butuh route tambahan untuk form `create`
    Route::get('perkembangan/create', [TahapanPerkembanganController::class, 'create'])->name('perkembangan.create');
    Route::resource('nutrition', NutritionController::class)->except(['show']);
});

// Artikel User
Route::prefix('orangtua/artikel')->name('orangtua.artikel.')->middleware('auth')->group(function () {
    Route::get('/', [UserArtikelController::class, 'index'])->name('index');
    Route::get('/{id}', [UserArtikelController::class, 'show'])->name('show');
});

// Orangtua
Route::prefix('orangtua')->name('orangtua.')->middleware('auth')->group(function () {
    Route::resource('immunization_records', ImmunizationRecordController::class);
    Route::resource('tahapan_perkembangan', TahapanPerkembanganDataController::class);
});

// Nutrition Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
    Route::get('/nutrition/create', [NutritionController::class, 'create'])->name('nutrition.create');
    Route::post('/nutrition', [NutritionController::class, 'store'])->name('nutrition.store');
    Route::get('/nutrition/{id}/edit', [NutritionController::class, 'edit'])->name('nutrition.edit');
    Route::put('/nutrition/{id}', [NutritionController::class, 'update'])->name('nutrition.update');
    Route::delete('/nutrition/{id}', [NutritionController::class, 'delet'])->name('nutrition.delet');
});

// Nutrition Orangtua
Route::middleware(['auth'])->group(function () {
    Route::get('/nutritionUs', function (Request $request) {
        if (auth()->user()->role !== 'orangtua') abort(403, 'Unauthorized');
        $kategori = $request->query('kategori');
        $menus = $kategori
            ? NutritionRecommendation::where('category', $kategori)->get()
            : NutritionRecommendation::all();
        return view('nutritionUs.index', compact('menus', 'kategori'));
    })->name('nutritionUs.index');

    Route::get('/nutritionUs/{id}', function (string $id) {
        if (auth()->user()->role !== 'orangtua') abort(403, 'Unauthorized');
        $menu = NutritionRecommendation::findOrFail($id);
        return view('nutritionUs.show', compact('menu'));
    })->name('nutritionUs.show');
});

// BMI
Route::get('/bmi', [BMICalculatorController::class, 'showBmiData'])->name('bmi');
Route::post('/hitung-bmi', [BMICalculatorController::class, 'calculate'])->name('hitung-bmi');
Route::post('/simpan-bmi', [BMICalculatorController::class, 'save'])->name('simpan-bmi');
Route::post('/reset-bmi', [BMICalculatorController::class, 'reset'])->name('reset-bmi');
Route::post('/hapus-bmi/{index}', [BMICalculatorController::class, 'deleteRow'])->name('hapus-bmi-row');

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
