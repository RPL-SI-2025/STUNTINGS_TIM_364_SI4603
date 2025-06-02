<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;

class SearchNutritionFail2Test extends TestCase
{
    // Gagal akses tanpa filter kategori (langsung akses tanpa query kategori)
    public function test_fail_access_without_filter()
    {
        $orangtua = User::where('role', 'orangtua')->first();
        $this->assertNotNull($orangtua);

        $response = $this->actingAs($orangtua)->get('/nutrition/user');

        // Contoh: Asumsikan kalau akses tanpa filter itu gagal, misal 404 atau 403
        $this->assertNotEquals(200, $response->status());

        // Pastikan response bukan view supaya tidak error
        $this->assertFalse($response->baseResponse instanceof \Illuminate\View\View);
    }
}
