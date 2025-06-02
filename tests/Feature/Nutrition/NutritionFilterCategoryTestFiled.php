<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NutritionFilterCategoryFailedTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_category_returns_empty_if_category_not_exist()
    {
        $user = User::create([
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
        ]);

        // Filter kategori yang tidak ada
        $response = $this->actingAs($user)->get(route('orangtua.nutritionUs.index', ['category' => 'kategori_tidak_ada']));

        $response->assertStatus(200);
        $response->assertViewHas('menus', function ($menus) {
            // Harus kosong karena kategori tidak ada
            return $menus->isEmpty();
        });
    }
}
