<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaUpdateSucessTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_update_tahapan_perkembangan()
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

        // Menyimulasikan login sebagai orangtua dan mengirimkan data yang akan diupdate
        $response = $this->actingAs($orangtua)->put('/orangtua/tahapan_perkembangan/' . $tahapanPerkembanganData->id, [
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => now()->toDateString(),
            'status' => 'belum_tercapai',
            'catatan' => 'Catatan baru',
        ]);

        // Menguji apakah data berhasil diupdate dan pengguna diarahkan ke halaman indeks
        $response->assertRedirect(route('orangtua.tahapan_perkembangan.index'));
        $response->assertSessionHas('success', 'Pencapaian tahapan perkembangan berhasil diupdate.');

        // Verifikasi apakah data berhasil diupdate di database
        $this->assertDatabaseHas('tahapan_perkembangan_data', [
            'user_id' => $orangtua->id,
            'status' => 'belum_tercapai',
            'catatan' => 'Catatan baru',
        ]);
    }
}
