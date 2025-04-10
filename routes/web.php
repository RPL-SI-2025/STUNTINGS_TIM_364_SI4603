<?php

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
    return view('welcome');
});
