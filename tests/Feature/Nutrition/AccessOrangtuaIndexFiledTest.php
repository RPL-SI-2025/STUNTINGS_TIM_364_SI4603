<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessOrangtuaIndexFiledTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_orangtua_user_cannot_access_nutrition_index()
    {
        // Buat user dengan role admin
        $user = User::create([
            'nama_anak' => 'admin dummy',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('admin123'),
            'role' => 'admin', // bukan orangtua
        ]);
    
        // Login dan akses halaman
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.index'));
    
        // Harus forbidden (403)
        $response->assertStatus(403);
    }
    
}
