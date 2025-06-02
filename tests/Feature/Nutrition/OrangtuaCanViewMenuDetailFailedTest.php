<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;

class OrangtuaCanViewMenuDetailFailedTest extends TestCase
{
    public function test_orangtua_cannot_view_invalid_nutrition_detail()
    {
        // Buat user orangtua
        $user = User::create([
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123450',
        ]);

        // Gunakan ID menu yang tidak ada
        $invalidMenuId = 9999;

        // Login sebagai orangtua dan coba akses detail menu yang tidak ada
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.show', $invalidMenuId));

        // Pastikan respons adalah 404 (Not Found)
        $response->assertStatus(404);
    }
}
