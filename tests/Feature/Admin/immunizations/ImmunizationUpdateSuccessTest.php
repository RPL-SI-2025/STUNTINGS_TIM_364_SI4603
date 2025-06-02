<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Immunization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationUpdateSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_immunization_with_valid_data()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $immunization = Immunization::create([
            'name' => 'BCG',
            'age' => '1 bulan',
            'description' => 'Deskripsi awal',
        ]);

        $response = $this->actingAs($admin)->put("/admin/immunizations/{$immunization->id}", [
            'name' => 'BCG Update',
            'age' => '2 bulan',
            'description' => 'Deskripsi setelah update',
        ]);

        $response->assertRedirect(route('admin.immunizations.index'));

        $this->assertDatabaseHas('immunizations', [
            'id' => $immunization->id,
            'name' => 'BCG Update',
            'age' => '2 bulan',
            'description' => 'Deskripsi setelah update',
        ]);
    }
}
