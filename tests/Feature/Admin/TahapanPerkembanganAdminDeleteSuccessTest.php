<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TahapanPerkembanganAdminDeleteSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_tahapan_perkembangan()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $tahapan = TahapanPerkembangan::create([
            'nama_tahapan' => 'Tahapan Tes',
            'deskripsi' => 'Deskripsi tes',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.tahapan_perkembangan.destroy', $tahapan->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('tahapan_perkembangan', [
            'id' => $tahapan->id,
        ]);
    }
}
