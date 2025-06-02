<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TahapanPerkembanganAdminDeleteInvalidIdTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_delete_fails_when_id_not_found()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Simulasi ID tidak valid (misalnya 999)
        $response = $this->actingAs($admin)->delete('/Admin/tahapan_perkembangan/999');

        $response->assertStatus(404);
    }
}
