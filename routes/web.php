<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NutritionController;
use App\Models\NutritionRecommendation;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition.index');
Route::get('/nutrition/create', [NutritionController::class, 'create'])->name('nutrition.create');
Route::post('/nutrition', [NutritionController::class, 'store'])->name('nutrition.store');
Route::get('/nutrition/{id}/edit', [NutritionController::class, 'edit'])->name('nutrition.edit');
Route::put('/nutrition/{id}', [NutritionController::class, 'update'])->name('nutrition.update');
Route::delete('/nutrition/{id}', [NutritionController::class, 'delet'])->name('nutrition.delet');

Route::get('/nutritionUs', function (Request $request) {

        $kategori = $request->query('kategori');

        if ($kategori) {
            $menus = NutritionRecommendation::where('category', $kategori)->get();

        } else {
            $menus = NutritionRecommendation::all();
        }

        return view('nutritionUs.index', compact('menus', 'kategori'));

} )->name('nutritionUs.index');


Route::get('/nutritionUs/{id}', function (string $id) {
    $menu = NutritionRecommendation::find($id);
    return view('nutritionUs.show', compact('menu'));
} )->name('nutritionUs.show');
