<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NutritionFilterCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_filter_menu_by_category()
    {
        // Buat user orangtua
        $user = User::create([
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
        ]);

        // Akses halaman dengan filter kategori pagi
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.index', ['category' => 'pagi']));

        $response->assertStatus(200);
        $response->assertViewHas('menus', function ($menus) {
            // Semua menu yang tampil harus kategori pagi
            foreach ($menus as $menu) {
                if ($menu->category !== 'pagi') {
                    return false;
                }
            }
            return true;
        });
    }
}
