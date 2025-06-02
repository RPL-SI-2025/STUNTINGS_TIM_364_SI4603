<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminAddNutritionSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_nutrition_successfully()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('menu.jpg');

        $response = $this->actingAs($admin)->post('/admin/nutrition', [
            'name' => 'Nasi Tim Ayam',
            'nutrition' => 'Karbohidrat, Protein',
            'ingredients' => 'Nasi, Ayam, Wortel',
            'instructions' => 'Kukus nasi dan ayam, campurkan.',
            'category' => 'pagi',
            'image' => $image,
        ]);

        $response->assertRedirect('/admin/nutrition');
        $this->assertDatabaseHas('nutrition_recommendations', [
            'name' => 'Nasi Tim Ayam',
        ]);
    }
}