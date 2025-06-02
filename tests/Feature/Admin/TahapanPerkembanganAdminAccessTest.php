<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TahapanPerkembanganAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_tahapan_perkembangan_index()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/tahapan_perkembangan');

        $response->assertStatus(200);
        $response->assertViewIs('admin.tahapan_perkembangan.index');
    }
}