<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminArtikelFilterNegativeTest extends TestCase
{
    /** @test */
    public function test_admin_filter_artikel_tidak_ditemukan()
    {
        // Ambil user admin berdasarkan nik_anak
        $admin = User::where('nik_anak', '1234567890123456')->first();
        $this->assertNotNull($admin, 'Admin user tidak ditemukan!');

        // Login sebagai admin
        $this->actingAs($admin);

        // Lakukan pencarian dengan keyword tidak valid
        $response = $this->get('/admin/artikel?search=xyzartikelgaksesuatuunik');

        // Periksa status dan pesan kosong
        $response->assertStatus(200);
        $response->assertSeeText('Belum ada artikel yang tersedia.');
    }
}
