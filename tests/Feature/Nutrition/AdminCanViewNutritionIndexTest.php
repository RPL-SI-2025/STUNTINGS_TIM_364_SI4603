<?php

// tests/Feature/Nutrition/AdminCanViewNutritionIndexTest.php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCanViewNutritionIndexTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Simpan admin secara manual karena RefreshDatabase menghapus semua data
        $this->admin = User::create([
            'nama_anak' => 'Admin Satu',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
    }

    public function test_admin_can_view_nutrition_index()
    {
        $response = $this->actingAs($this->admin)->get('/admin/nutrition');

        $response->assertStatus(200);
        $response->assertViewIs('admin.nutrition.index');
    }
}
