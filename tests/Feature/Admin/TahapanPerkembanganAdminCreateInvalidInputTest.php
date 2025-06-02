<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TahapanPerkembanganAdminCreateInvalidInputTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_create_fails_due_to_invalid_umur_minimal_bulan()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $data = [
            'nama_tahapan' => 'Berjalan',
            'deskripsi' => 'Invalid umur',
            'umur_minimal_bulan' => 'enam', // Invalid input
            'umur_maksimal_bulan' => 18,
        ];

        $response = $this->actingAs($admin)
                         ->post('/admin/tahapan_perkembangan', $data);

        $response->assertSessionHasErrors('umur_minimal_bulan');
    }
}
