<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaCreateNoTest extends TestCase
{
    use RefreshDatabase;

    // Test untuk memastikan gagal menyimpan data jika validasi gagal
    public function test_orangtua_cannot_store_invalid_tahapan_perkembangan()
    {
        // Membuat pengguna dengan role 'orangtua'
        $orangtua = User::create([
            'nama_anak' => 'Rara',
            'nik_anak' => '1234567890123333',
            'password' => Hash::make('123456'),
            'role' => 'orangtua',
        ]);

        // Menyimulasikan login sebagai orangtua dan mengirimkan data yang tidak valid
        $response = $this->actingAs($orangtua)->post('/orangtua/tahapan_perkembangan', [
            'tahapan_perkembangan_id' => '', // Data tidak valid
            'tanggal_pencapaian' => 'invalid-date',
            'status' => 'invalid-status', // Status tidak valid
        ]);

        // Menguji apakah validasi gagal dan halaman tidak berhasil disubmit
        $response->assertSessionHasErrors(['tahapan_perkembangan_id', 'tanggal_pencapaian', 'status']);
    }
}
