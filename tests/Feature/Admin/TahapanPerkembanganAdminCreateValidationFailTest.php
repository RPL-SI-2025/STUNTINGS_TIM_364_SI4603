<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TahapanPerkembanganAdminCreateValidationFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_create_fails_due_to_missing_nama_tahapan()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $data = [
            'nama_tahapan' => '', // Field required kosong
            'deskripsi' => 'Tes kosong nama',
            'umur_minimal_bulan' => 6,
            'umur_maksimal_bulan' => 12,
        ];

        $response = $this->actingAs($admin)
                         ->post('/admin/tahapan_perkembangan', $data);

        $response->assertSessionHasErrors('nama_tahapan');
    }
}
