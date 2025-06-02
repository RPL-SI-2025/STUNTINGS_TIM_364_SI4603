<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class OrangtuaArtikelFilterNegativeTest extends TestCase
{
    /** @test */
    public function orangtua_memfilter_artikel_tetapi_tidak_ditemukan()
    {
        // Ambil user orangtua dari database
        $orangtua = User::where('role', 'orangtua')->first();

        // Pastikan user ditemukan
        $this->assertNotNull($orangtua, 'User orangtua tidak ditemukan di database!');

        // Login sebagai orangtua
        $this->actingAs($orangtua);

        // Gunakan ID kategori yang tidak memiliki artikel apapun
        // Misalnya kategori ID 99 dianggap tidak ada datanya
        $response = $this->get('/orangtua/artikel?kategori[]=99');

        // Pastikan halaman bisa diakses
        $response->assertStatus(200);

        // Harus menampilkan pesan kosong atau tidak menampilkan artikel sama sekali
        // Sesuaikan dengan konten HTML atau teks kosongmu
        $response->assertSeeText('Tidak ada artikel ditemukan'); // ← ganti jika pesan kosong kamu beda
    }
}
