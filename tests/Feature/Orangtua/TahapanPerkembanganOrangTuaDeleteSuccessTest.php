<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaDeleteSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_delete_tahapan_perkembangan()
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

        // Membuat data tahapan perkembangan yang akan dihapus
        $tahapanPerkembanganData = TahapanPerkembanganData::create([
            'user_id' => $orangtua->id,
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => now()->toDateString(),
            'status' => 'tercapai',
            'catatan' => 'Catatan lama',
        ]);

        // Menyimulasikan login sebagai orangtua dan mengirimkan permintaan untuk menghapus data
        $response = $this->actingAs($orangtua)->delete('/orangtua/tahapan_perkembangan/' . $tahapanPerkembanganData->id);

        // Menguji apakah data berhasil dihapus dan pengguna diarahkan ke halaman indeks
        $response->assertRedirect(route('orangtua.tahapan_perkembangan.index'));
        $response->assertSessionHas('success', 'Pencapaian tahapan perkembangan berhasil dihapus.');

        // Verifikasi apakah data sudah tidak ada di database
        $this->assertDatabaseMissing('tahapan_perkembangan_data', [
            'id' => $tahapanPerkembanganData->id
        ]);
    }
}
