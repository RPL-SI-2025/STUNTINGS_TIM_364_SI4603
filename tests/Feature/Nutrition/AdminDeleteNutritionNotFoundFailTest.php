<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AdminDeleteNutritionNotFoundFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_delete_nutrition_with_invalid_id_should_fail()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $invalidId = 999;

        $response = $this->actingAs($admin)->delete("/admin/nutrition/{$invalidId}");

        $response->assertStatus(404);
    }
}
