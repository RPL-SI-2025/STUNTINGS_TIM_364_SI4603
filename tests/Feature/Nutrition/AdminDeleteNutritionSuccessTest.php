<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\NutritionRecommendation;

class AdminDeleteNutritionSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_nutrition_successfully()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $menu = NutritionRecommendation::create([
            'name' => 'Menu Delete',
            'nutrition' => 'Vitamin',
            'ingredients' => 'Buah',
            'instructions' => 'Kupas dan makan',
            'category' => 'snack',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/nutrition/{$menu->id}");

        $response->assertRedirect('/admin/nutrition');
        $this->assertDatabaseMissing('nutrition_recommendations', ['id' => $menu->id]);
    }
}
