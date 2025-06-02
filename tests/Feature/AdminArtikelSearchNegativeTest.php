<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminArtikelSearchNegativeTest extends TestCase
{
    /** @test */
    public function test_admin_search_artikel_tidak_ditemukan()
    {
        // Ambil admin dari database
        $admin = User::where('nik_anak', '1234567890123456')->first();

        // Pastikan admin ditemukan
        $this->assertNotNull($admin, 'Admin user tidak ditemukan di database!');

        // Login sebagai admin
        $this->actingAs($admin);

        // Lakukan pencarian dengan keyword yang dipastikan tidak ada
        $response = $this->get('/admin/artikel?search=xyzartikelgaksesuatuunik');

        // Cek status
        $response->assertStatus(200);

        // Cek tidak ada hasil ditemukan
        $response->assertSeeText('Belum ada artikel yang tersedia.');
    }
}
