<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangTuaDeleteDataFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_delete_tahapan_perkembangan_with_invalid_id()
    {
        // Membuat pengguna dengan role 'orangtua'
        $orangtua = User::create([
            'nama_anak' => 'Rara',
            'nik_anak' => '1234567890123333',
            'password' => Hash::make('123456'),
            'role' => 'orangtua',
        ]);

        // ID yang tidak valid (data tidak ada di database)
        $invalidId = 9999;

        // Menyimulasikan login sebagai orangtua dan mencoba menghapus data dengan ID yang tidak ada
        $response = $this->actingAs($orangtua)->delete('/orangtua/tahapan_perkembangan/' . $invalidId);

        // Menguji apakah halaman menampilkan error karena data tidak ditemukan
        $response->assertStatus(404);  // Harus menampilkan error 404 karena data tidak ditemukan
    }
}
