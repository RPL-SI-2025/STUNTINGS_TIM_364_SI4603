<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaUpdateTanggalFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_update_tahapan_perkembangan_with_invalid_tanggal_pencapaian()
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

        // Menyimulasikan login sebagai orangtua dan mengirimkan tanggal tidak valid
        $response = $this->actingAs($orangtua)->put('/orangtua/tahapan_perkembangan/' . $tahapanPerkembanganData->id, [
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => 'invalid-date',  // Tanggal tidak valid
            'status' => 'belum_tercapai',
            'catatan' => 'Catatan baru',
        ]);

        // Menguji apakah validasi gagal dan halaman tidak berhasil disubmit
        $response->assertSessionHasErrors('tanggal_pencapaian');
    }
}
