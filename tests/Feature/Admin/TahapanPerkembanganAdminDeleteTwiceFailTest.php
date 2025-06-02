<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TahapanPerkembanganAdminDeleteTwiceFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_delete_fails_if_already_deleted()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $tahapan = TahapanPerkembangan::create([
            'nama_tahapan' => 'Tahapan Tes',
            'deskripsi' => 'Deskripsi',
        ]);

        // Pertama kali: berhasil
        $this->actingAs($admin)->delete(route('admin.tahapan_perkembangan.destroy', $tahapan->id));

        // Kedua kali: harus gagal
        $response = $this->actingAs($admin)->delete(route('admin.tahapan_perkembangan.destroy', $tahapan->id));

        $response->assertStatus(404); // Model binding gagal karena sudah dihapus
    }
}
