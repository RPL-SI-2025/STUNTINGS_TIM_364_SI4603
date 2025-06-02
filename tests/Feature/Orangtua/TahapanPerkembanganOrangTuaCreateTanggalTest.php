<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaCreateTanggalTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_store_tahapan_perkembangan_with_invalid_tanggal_pencapaian()
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

        // Menyimulasikan login sebagai orangtua dan mengirimkan data dengan tanggal tidak valid
        $response = $this->actingAs($orangtua)->post('/orangtua/tahapan_perkembangan', [
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => 'invalid-date',  // Tanggal yang tidak valid
            'status' => 'tercapai',
            'catatan' => 'Catatan valid',
        ]);

        // Menguji apakah validasi gagal karena tanggal pencapaian tidak valid
        $response->assertSessionHasErrors('tanggal_pencapaian');
    }
}
