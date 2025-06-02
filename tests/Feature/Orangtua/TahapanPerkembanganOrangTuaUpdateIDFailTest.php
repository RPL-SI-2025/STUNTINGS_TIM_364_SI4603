<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaUpdateIDFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_update_tahapan_perkembangan_with_invalid_tahapan_perkembangan_id()
    {
        // Membuat pengguna dengan role 'orangtua'
        $orangtua = User::create([
            'nama_anak' => 'Rara',
            'nik_anak' => '1234567890123333',
            'password' => Hash::make('123456'),
            'role' => 'orangtua',
        ]);

        // Membuat data tahapan perkembangan yang valid
        $tahapanPerkembangan = TahapanPerkembangan::create([
            'nama_tahapan' => 'Tahapan 1',
            'deskripsi' => 'Deskripsi Tahapan 1',
        ]);

        // Membuat data tahapan perkembangan untuk diupdate
        $tahapanPerkembanganData = TahapanPerkembanganData::create([
            'user_id' => $orangtua->id,
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => now()->toDateString(),
            'status' => 'tercapai',
            'catatan' => 'Catatan lama',
        ]);

        // Menyimulasikan login sebagai orangtua dan mengirimkan data dengan tahapan_perkembangan_id tidak valid
        $response = $this->actingAs($orangtua)->put('/orangtua/tahapan_perkembangan/' . $tahapanPerkembanganData->id, [
            'tahapan_perkembangan_id' => 999,  // ID yang tidak ada di database
            'tanggal_pencapaian' => now()->toDateString(),
            'status' => 'belum_tercapai',
            'catatan' => 'Catatan baru',
        ]);

        // Menguji apakah validasi gagal dan halaman tidak berhasil disubmit
        $response->assertSessionHasErrors('tahapan_perkembangan_id');
    }
}
