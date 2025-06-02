<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminArtikelSearchTest extends TestCase
{
    /** @test */
    public function admin_dapat_mencari_artikel_berdasarkan_judul()
    {
        // Login sebagai admin
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);
        $this->actingAs($admin);

        // Kata kunci pencarian, misalnya "Baby"
        $response = $this->get('/admin/artikel?search=Baby');

        $response->assertStatus(200);

        // Pastikan artikel yang mengandung "baby" muncul
        $response->assertSeeText('Contoh Artikel Kategori baby');

        // Pastikan artikel lain tidak muncul (opsional, hanya jika kamu yakin keyword-nya eksklusif)
        $response->assertDontSeeText('Contoh Artikel Kategori New Moms');
    }
}
