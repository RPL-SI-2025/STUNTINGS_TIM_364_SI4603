<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class OrangtuaArtikelSearchTest extends TestCase
{
    /** @test */
    public function orangtua_dapat_mencari_artikel_berdasarkan_judul()
    {
        // Ambil user orangtua dari database
        $orangtua = User::where('role', 'orangtua')->first();

        $this->assertNotNull($orangtua, 'User orangtua tidak ditemukan di database!');

        $this->actingAs($orangtua);

        // Cari berdasarkan kata kunci 'baby'
        $response = $this->get('/orangtua/artikel?search=baby');

        $response->assertStatus(200);
        $response->assertSeeText('Contoh Artikel Kategori baby');
    }

    /** @test */
    public function orangtua_mencari_artikel_tetapi_tidak_ditemukan()
    {
        $orangtua = User::where('role', 'orangtua')->first();

        $this->assertNotNull($orangtua, 'User orangtua tidak ditemukan di database!');

        $this->actingAs($orangtua);

        $response = $this->get('/orangtua/artikel?search=tidakadadata');

        $response->assertStatus(200);
        $response->assertSeeText('Tidak ada artikel ditemukan.');
    }
}
