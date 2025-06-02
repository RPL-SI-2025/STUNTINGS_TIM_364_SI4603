<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class OrangtuaArtikelSearchNegativeTest extends TestCase
{
    /** @test */
    public function orangtua_mencari_artikel_dengan_kata_kunci_yang_tidak_ditemukan()
    {
        // Ambil user orangtua dari database
        $orangtua = User::where('role', 'orangtua')->first();

        // Pastikan user ditemukan
        $this->assertNotNull($orangtua, 'User orangtua tidak ditemukan di database!');

        // Login sebagai orangtua
        $this->actingAs($orangtua);

        // Lakukan pencarian dengan kata kunci yang tidak ada di database
        $response = $this->get('/orangtua/artikel?search=tidakadadataunik');

        // Pastikan halaman dapat diakses
        $response->assertStatus(200);

        // Validasi bahwa pesan "Tidak ada artikel ditemukan." muncul
        $response->assertSeeText('Tidak ada artikel ditemukan.');
    }
}
