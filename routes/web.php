<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TahapanPerkembanganController;

Route::get('/', function () {
    return view('welcome');
});

// Tampilkan form input data
Route::get('/adminTahapan/index', [TahapanPerkembanganController::class, 'create'])->name('admin.tahapanPerkembangan.create');

// Simpan data perkembangan anak
Route::post('/admin/tahapan-perkembangan', [TahapanPerkembanganController::class, 'store'])->name('admin.tahapanPerkembangan.store');
