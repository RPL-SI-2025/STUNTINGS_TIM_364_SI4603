<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAddNutritionValidationFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_add_nutrition_fails_due_to_missing_fields()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $response = $this->actingAs($admin)->post('/admin/nutrition', [
            // semua field kosong
        ]);

        $response->assertSessionHasErrors([
            'name',
            'nutrition',
            'ingredients',
            'instructions',
            'category',
        ]);
    }
}
