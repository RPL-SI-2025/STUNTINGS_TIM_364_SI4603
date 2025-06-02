<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test untuk memastikan orangtua bisa menyimpan data tahapan perkembangan dengan valid
    public function test_orangtua_can_store_tahapan_perkembangan()
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

        // Menyimulasikan login sebagai orangtua dan mengirimkan data
        $response = $this->actingAs($orangtua)->post('/orangtua/tahapan_perkembangan', [
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'tanggal_pencapaian' => now()->toDateString(),
            'status' => 'tercapai',
            'catatan' => 'Catatan penting',
        ]);

        // Menguji apakah data berhasil disimpan dan pengguna diarahkan ke halaman indeks
        $response->assertRedirect(route('orangtua.tahapan_perkembangan.index'));
        $response->assertSessionHas('success', 'Pencapaian tahapan perkembangan berhasil ditambahkan.');

        // Verifikasi apakah data berhasil disimpan di database
        $this->assertDatabaseHas('tahapan_perkembangan_data', [
            'user_id' => $orangtua->id,
            'tahapan_perkembangan_id' => $tahapanPerkembangan->id,
            'status' => 'tercapai',
            'catatan' => 'Catatan penting',
        ]);
    }
}