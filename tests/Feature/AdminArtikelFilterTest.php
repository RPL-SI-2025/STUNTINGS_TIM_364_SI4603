<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminArtikelFilterTest extends TestCase
{
    /** @test */
    public function admin_dapat_memfilter_artikel_dengan_kategori_id()
    {
        // Ambil user admin dari database
        $admin = User::where('role', 'admin')->first();

        // Pastikan admin ada
        $this->assertNotNull($admin, 'Admin user tidak ditemukan di database!');

        // Login sebagai admin
        $this->actingAs($admin);

        // Gunakan ID kategori yang sesuai, misalnya ID 5 untuk kategori "Baby"
        $response = $this->get('/admin/artikel?kategori[]=1');

        // Pastikan halaman bisa diakses
        $response->assertStatus(200);

        // Artikel dengan kategori ID 5 (baby) harus muncul
        $response->assertSeeText('Contoh Artikel Kategori baby');

        // Artikel dari kategori lain tidak boleh muncul
        $response->assertDontSeeText('Contoh Artikel Kategori 3-6 Tahun');
        $response->assertDontSeeText('Contoh Artikel Kategori New Moms');
        $response->assertDontSeeText('Contoh Artikel Kategori 0-3 Tahun');
        $response->assertDontSeeText('Contoh Artikel Kategori 6-12 Tahun');
    }
}
