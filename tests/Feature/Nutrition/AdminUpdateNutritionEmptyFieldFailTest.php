<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\NutritionRecommendation;

class AdminUpdateNutritionEmptyFieldFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_update_fails_due_to_empty_fields()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $menu = NutritionRecommendation::create([
            'name' => 'Menu Lama',
            'nutrition' => 'Karbohidrat',
            'ingredients' => 'Nasi',
            'instructions' => 'Rebus nasi',
            'category' => 'pagi',
        ]);

        $response = $this->actingAs($admin)->put("/admin/nutrition/{$menu->id}", [
            'name' => '',
            'nutrition' => '',
            'ingredients' => '',
            'instructions' => '',
            'category' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'nutrition', 'ingredients', 'instructions', 'category']);
    }
}
