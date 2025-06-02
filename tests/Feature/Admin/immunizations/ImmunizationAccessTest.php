<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_immunization_index()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/immunizations');

        $response->assertStatus(200);
        $response->assertViewIs('admin.immunizations.index');
    }
}
