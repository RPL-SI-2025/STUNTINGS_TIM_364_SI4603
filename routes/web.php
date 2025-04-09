<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NutritionController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
Route::get('/nutrition/create', [NutritionController::class, 'create'])->name('nutrition.create');
Route::post('/nutrition', [NutritionController::class, 'store'])->name('nutrition.store');
Route::get('/nutrition/{id}/edit', [NutritionController::class, 'edit'])->name('nutrition.edit');
Route::put('/nutrition/{id}', [NutritionController::class, 'update'])->name('nutrition.update');
Route::delete('/nutrition/{id}', [NutritionController::class, 'delet'])->name('nutrition.delet');
