<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use App\Models\Category;  // Jika kategori ada di fitur Tahapan Perkembangan
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangtuaFilterSuccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_access_tahapan_perkembangan_index()
    {
        // Buat user orangtua secara manual
        $user = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
            'role' => 'orangtua',
        ]);
        
        // Akses route yang benar untuk halaman tahapan perkembangan
        $response = $this->actingAs($user)->get(route('orangtua.tahapan_perkembangan.index'));

        // Pastikan halaman berhasil dimuat dan view sesuai
        $response->assertStatus(200);
        $response->assertViewIs('orangtua.tahapan_perkembangan.index');
        $response->assertViewHasAll(['data', 'kategoris', 'kategoriIds']);
    }
}
