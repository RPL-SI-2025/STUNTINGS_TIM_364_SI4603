<?php

namespace Tests\Feature\AdminArtikel;

use Tests\TestCase;
use App\Models\User;
use App\Models\ArtikelKategori;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtikelKategoriFilterTest extends TestCase
{
    use RefreshDatabase;

    // 1. Test sukses: admin bisa filter kategori artikel dengan keyword yang ada
    public function test_admin_can_filter_kategori_artikel_by_name_success()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        ArtikelKategori::create(['name' => 'Teknologi']);
        ArtikelKategori::create(['name' => 'Kesehatan']);
        ArtikelKategori::create(['name' => 'Olahraga']);

        $response = $this->actingAs($admin)->get(route('admin.artikel.kategori.index', ['search' => 'Tekno']));

        $response->assertStatus(200);
        $response->assertSee('Teknologi');
        $response->assertDontSee('Kesehatan');
        $response->assertDontSee('Olahraga');
    }

    // 2. Test gagal: user non-admin tidak bisa mengakses halaman filter kategori artikel
    public function test_non_admin_cannot_access_kategori_filter()
    {
        $user = User::factory()->create(['role' => 'user']); // role selain admin
        
        $response = $this->actingAs($user)->get(route('admin.artikel.kategori.index', ['search' => 'Tekno']));

        $response->assertStatus(403);
    }

    // 3. Test gagal: admin memasukkan query kosong (atau tidak ada hasil), harus tampil pesan kategori tidak ditemukan
    public function test_admin_filter_kategori_with_no_results_shows_message()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        ArtikelKategori::create(['name' => 'Teknologi']);

        $response = $this->actingAs($admin)->get(route('admin.artikel.kategori.index', ['search' => 'NamaTidakAda']));

        $response->assertStatus(200);
        $response->assertDontSee('Teknologi');
        $response->assertSee('Kategori tidak ditemukan'); // Sesuaikan pesan ini dengan view
    }
}
