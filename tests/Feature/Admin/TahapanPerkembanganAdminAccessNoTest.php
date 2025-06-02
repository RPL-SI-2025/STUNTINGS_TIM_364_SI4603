<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganAdminAccessNoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_access_perkembangan_index_without_authentication()
    {
        // Akses halaman tanpa login
        $response = $this->get('/admin/tahapan_perkembangan');

        // Pastikan pengguna yang tidak login diarahkan ke halaman login
        $response->assertRedirect(route('login'));
    }
}
