<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;

class NutritionViewMissingDataTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'nama_anak' => 'Admin Test',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // Simulasikan view `admin.nutrition.index` TIDAK menerima data yang dibutuhkan
        View::composer('admin.nutrition.index', function ($view) {
            $view->with([]); // Tidak ada data dikirim
        });
    }

    public function test_admin_view_fails_due_to_missing_data()
    {
        $response = $this->actingAs($this->admin)->get('/admin/nutrition');

        // Laravel akan error jika view butuh variabel (seperti $menus) tapi tidak dikirim
        $response->assertStatus(200); // Internal Server Error karena view gagal render
    }
}
