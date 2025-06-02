<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangtuaFilterIDFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_filter_tahapan_perkembangan_with_non_existent_category()
    {
        // Membuat pengguna dengan role 'orangtua'
        $user = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
        ]);
        
        // ID kategori yang tidak ada di database
        $invalidCategoryId = 9999;

        // Menyimulasikan login sebagai orangtua dan mengirimkan permintaan untuk memfilter dengan kategori yang tidak ada
        $response = $this->actingAs($user)->get(route('orangtua.tahapan_perkembangan.index', [
            'kategori' => [$invalidCategoryId]  // Mengirimkan ID kategori yang tidak ada
        ]));

        // Menguji apakah halaman berhasil dimuat dengan data kosong karena kategori tidak ada
        $response->assertStatus(200);
        $response->assertSee('Belum ada pencapaian yang tercatat.');  // Harus menampilkan pesan ketika data tidak ditemukan
    }
}
