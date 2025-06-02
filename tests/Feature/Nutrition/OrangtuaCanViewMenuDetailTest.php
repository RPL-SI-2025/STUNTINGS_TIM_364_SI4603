<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;

class OrangtuaCanViewMenuDetailTest extends TestCase
{
    public function test_orangtua_can_view_nutrition_detail()
    {
        // Buat user orangtua
        $user = User::create([
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123450',
        ]);

        // Ambil salah satu menu dari database
        $menu = NutritionRecommendation::first();
        $this->assertNotNull($menu, 'Data menu tidak ditemukan. Pastikan ada data di tabel nutrition_recommendations.');

        // Login sebagai user orangtua dan buka detail menu
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.show', $menu->id));

        // Validasi halaman tampil
        $response->assertStatus(200);
        $response->assertViewIs('orangtua.nutritionus.show');
        $response->assertViewHas('menu', function ($data) use ($menu) {
            return $data->id === $menu->id;
        });
    }
}
