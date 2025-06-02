<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangtuaFilterFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_filter_tahapan_perkembangan_with_empty_category_filter()
    {
        // Membuat pengguna dengan role 'orangtua'
        $user = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
        ]);

        // Menyimulasikan login sebagai orangtua dan mengirimkan permintaan untuk memfilter tanpa kategori
        $response = $this->actingAs($user)->get(route('orangtua.tahapan_perkembangan.index', [
            'kategori' => []  // Tidak ada kategori yang dipilih
        ]));

        // Menguji apakah halaman berhasil dimuat tanpa filter kategori dan data yang ada ditampilkan
        $response->assertStatus(200);
        $response->assertViewHas('data');  // Pastikan data yang ada ditampilkan
        $response->assertSee('Belum ada pencapaian yang tercatat.');  // Jika tidak ada data
    }
}
