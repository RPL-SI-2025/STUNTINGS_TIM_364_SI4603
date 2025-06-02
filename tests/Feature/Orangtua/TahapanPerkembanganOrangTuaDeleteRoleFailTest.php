<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaDeleteRoleFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_orangtua_user_cannot_delete_tahapan_perkembangan()
    {
        // Membuat pengguna dengan role selain 'orangtua', misalnya 'admin'
        $admin = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '9876543210123333',
            'password' => Hash::make('123456'),
            'role' => 'admin', // role yang tidak sesuai
        ]);

        // Membuat data tahapan perkembangan yang valid
        $tahapanPerkembangan = TahapanPerkembangan::create([
            'nama_tahapan' => 'Tahapan 1',
            'deskripsi' => 'Deskripsi Tahapan 1',
        ]);

        // Membuat data tahapan perkembangan untuk dihapus
        $tahapanPerkembanganData = TahapanPerkembanganData::create([
            'user_id' => $admin->id,
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => now()->toDateString(),
            'status' => 'tercapai',
            'catatan' => 'Catatan lama',
        ]);

        // Menyimulasikan login sebagai admin dan mencoba menghapus data
        $response = $this->actingAs($admin)->delete('/orangtua/tahapan_perkembangan/' . $tahapanPerkembanganData->id);

        // Menguji apakah akses ditolak karena role tidak sesuai
        $response->assertStatus(403);  // Harus menampilkan error 403 karena role tidak sesuai
    }
}
