<?php

namespace Tests\Feature\Orangtua;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangtuaAccessNoTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_cannot_access_perkembangan_index_without_authentication()
    {
        // Akses halaman tanpa login
        $response = $this->get('/orangtua/tahapan_perkembangan');

        // Pastikan pengguna yang tidak login diarahkan ke halaman login
        $response->assertRedirect(route('login'));
    }
}
