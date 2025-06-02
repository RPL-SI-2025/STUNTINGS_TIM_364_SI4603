<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class OrangtuaArtikelFilterTest extends TestCase
{
    /** @test */
    public function orangtua_dapat_memfilter_artikel_dengan_kategori_id()
    {
        // Ambil user orangtua dari database
        $orangtua = User::where('role', 'orangtua')->first();

        // Pastikan user ditemukan
        $this->assertNotNull($orangtua, 'User orangtua tidak ditemukan di database!');

        // Login sebagai orangtua
        $this->actingAs($orangtua);

        // Gunakan ID kategori yang sesuai, misalnya ID 1 untuk kategori "Baby"
        $response = $this->get('/orangtua/artikel?kategori[]=1');

        // Pastikan halaman bisa diakses
        $response->assertStatus(200);

        // Artikel dari kategori ID 1 harus muncul
        $response->assertSeeText('Contoh Artikel Kategori baby');

        // Artikel dari kategori lain tidak boleh muncul
        $response->assertDontSeeText('Contoh Artikel Kategori 3-6 Tahun');
        $response->assertDontSeeText('Contoh Artikel Kategori New Moms');
        $response->assertDontSeeText('Contoh Artikel Kategori 0-3 Tahun');
        $response->assertDontSeeText('Contoh Artikel Kategori 6-12 Tahun');
    }
}
