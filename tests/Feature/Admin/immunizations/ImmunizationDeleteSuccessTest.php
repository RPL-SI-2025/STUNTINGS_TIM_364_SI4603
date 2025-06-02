<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Immunization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationDeleteSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_immunization()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $immunization = Immunization::create([
            'name' => 'Campak',
            'age' => '9 bulan',
            'description' => 'Deskripsi awal',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/immunizations/{$immunization->id}");

        $response->assertRedirect(); 

        $this->assertDatabaseMissing('immunizations', [
            'id' => $immunization->id,
        ]);
    }
}
