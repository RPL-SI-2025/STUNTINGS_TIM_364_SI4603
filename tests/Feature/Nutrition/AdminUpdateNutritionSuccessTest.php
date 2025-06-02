<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\NutritionRecommendation;

class AdminUpdateNutritionSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_nutrition_successfully()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $menu = NutritionRecommendation::create([
            'name' => 'Menu Lama',
            'nutrition' => 'Protein',
            'ingredients' => 'Ayam',
            'instructions' => 'Goreng ayam',
            'category' => 'siang',
        ]);

        $response = $this->actingAs($admin)->put("/admin/nutrition/{$menu->id}", [
            'name' => 'Menu Baru',
            'nutrition' => 'Protein dan Lemak',
            'ingredients' => 'Ayam, Minyak',
            'instructions' => 'Goreng ayam dengan minyak',
            'category' => 'malam',
        ]);

        $response->assertRedirect('/admin/nutrition');
        $this->assertDatabaseHas('nutrition_recommendations', [
            'id' => $menu->id,
            'name' => 'Menu Baru',
        ]);
    }
}
