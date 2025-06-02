<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NutritionFilterCategoryFailed2Test extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_wrong_data()
    {
        $user = User::create([
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
        ]);

        // Search kata 'Soto' yang TIDAK ada
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.index', ['search' => 'Soto']));

        $response->assertStatus(200);
        $response->assertViewHas('menus', function ($menus) {
            // Kita paksa gagal dengan ngecek kalau hasil ada menu 'Nasi Goreng' padahal searchnya Soto
            foreach ($menus as $menu) {
                if ($menu->name === 'Nasi Goreng') {
                    return false; // seharusnya tidak muncul, jadi fail test ini
                }
            }
            return true;
        });
    }
}
