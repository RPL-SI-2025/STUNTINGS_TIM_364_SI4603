<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessOrangtuaIndexSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_access_nutrition_index()
    {
        // Buat user orangtua secara manual
        $user = User::create([
            'nama_anak' => 'budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
        ]);
        
        // Akses route yang benar
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.index'));

        // Pastikan halaman berhasil dimuat dan view sesuai
        $response->assertStatus(200);
        $response->assertViewIs('orangtua.nutritionUs.index');
        $response->assertViewHasAll(['menus', 'kategoris', 'kategoriIds']);
    }
}
