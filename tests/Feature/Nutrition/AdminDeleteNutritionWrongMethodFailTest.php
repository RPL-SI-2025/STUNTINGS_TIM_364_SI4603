<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\NutritionRecommendation;

class AdminDeleteNutritionWrongMethodFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_delete_nutrition_using_get_method_should_fail()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $menu = NutritionRecommendation::create([
            'name' => 'Menu Salah Method',
            'nutrition' => 'Karbohidrat',
            'ingredients' => 'Roti',
            'instructions' => 'Panggang roti',
            'category' => 'pagi',
        ]);

        $response = $this->actingAs($admin)->get("/admin/nutrition/{$menu->id}");

        $response->assertStatus(405); // Method Not Allowed
    }
}
