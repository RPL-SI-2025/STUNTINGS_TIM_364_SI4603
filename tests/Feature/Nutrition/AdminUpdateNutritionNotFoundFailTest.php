<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AdminUpdateNutritionNotFoundFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_update_fails_due_to_not_found_id()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $invalidId = 999;

        $response = $this->actingAs($admin)->put("/admin/nutrition/{$invalidId}", [
            'name' => 'Menu Baru',
            'nutrition' => 'Serat',
            'ingredients' => 'Sayur',
            'instructions' => 'Kukus sayur',
            'category' => 'siang',
        ]);

        $response->assertStatus(404);
    }
}
