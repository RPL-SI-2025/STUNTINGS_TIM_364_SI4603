<?php

// tests/Feature/Nutrition/NutritionViewWrongViewAssertionTest.php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NutritionViewWrongViewAssertionTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'nama_anak' => 'Admin Satu',
            'nik_anak' => '123456789012345',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
    }

    public function test_admin_view_nutrition_wrong_view_assertion_should_fail()
    {
        $response = $this->actingAs($this->admin)->get('/admin/nutrition');

        $response->assertStatus(200);
        $response->assertViewIs('admin.nutrition.index'); // salah nama view
    }
}
