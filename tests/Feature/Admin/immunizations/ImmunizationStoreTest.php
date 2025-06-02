<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Immunization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_store_immunization_with_valid_data()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/immunizations', [
            'name' => 'Hepatitis B',
            'age' => '0 bulan',
            'description' => 'Imunisasi pertama untuk bayi baru lahir',
        ]);

        $response->assertRedirect(route('admin.immunizations.index'));

        $this->assertDatabaseHas('immunizations', [
            'name' => 'Hepatitis B',
            'age' => '0 bulan',
            'description' => 'Imunisasi pertama untuk bayi baru lahir',
        ]);
    }
}
