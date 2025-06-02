<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TahapanPerkembanganAdminUpdateSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_tahapan_perkembangan()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $tahapan = TahapanPerkembangan::create([
            'nama_tahapan' => 'Tahapan Lama',
            'deskripsi' => 'Deskripsi Lama',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.tahapan_perkembangan.update', $tahapan->id), [
            'nama_tahapan' => 'Tahapan Baru',
            'deskripsi' => 'Deskripsi Baru',
        ]);

        $response->assertRedirect(route('admin.tahapan_perkembangan.index'));
        $this->assertDatabaseHas('tahapan_perkembangan', [
            'id' => $tahapan->id,
            'nama_tahapan' => 'Tahapan Baru',
            'deskripsi' => 'Deskripsi Baru',
        ]);
    }
}
