<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AdminAddNutritionInvalidImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_add_nutrition_fails_due_to_invalid_image_type()
    {
        $admin = User::create([
            'nama_anak' => 'Admin',
            'nik_anak' => '1234567890123456',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $fakeFile = UploadedFile::fake()->create('not-an-image.pdf', 100, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/nutrition', [
            'name' => 'Menu Invalid',
            'nutrition' => 'Protein',
            'ingredients' => 'Ayam',
            'instructions' => 'Goreng ayam',
            'category' => 'siang',
            'image' => $fakeFile,
        ]);

        $response->assertSessionHasErrors(['image']);
    }
}
